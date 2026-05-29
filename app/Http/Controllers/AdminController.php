<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // 1. Halaman Utama Dashboard Admin
    public function index()
    {
        $workOrders = WorkOrder::all();
        
        // Ambil 5 Work Order berstatus 'Pending' yang paling lama belum dikerjakan
        $urgentOrders = WorkOrder::where('status', 'Pending')
                                 ->orderBy('created_at', 'asc')
                                 ->take(5)
                                 ->get();

        return view('admin', compact('workOrders', 'urgentOrders'));
    }

    // 2. Halaman Daftar Semua Work Orders (+ Fitur Filter & Pencarian)
    public function orders(Request $request)
    {
        $filters = $request->only(['search', 'department', 'issue_type', 'status', 'from_date', 'to_date']);
        
        $query = WorkOrder::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('wo_number', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('issue_type')) {
            $query->where('issue_type', $request->issue_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [$request->from_date, $request->to_date . ' 23:59:59']);
        }

        $workOrders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin-orders', compact('workOrders', 'filters'));
    }

    // 3. Halaman Detail Work Order
    public function show($id)
    {
        $order = WorkOrder::findOrFail($id);
        return view('admin-detail', compact('order'));
    }

    // 4. Proses Mengubah Status Work Order
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,On Progress,Completed',
            // Wajibkan note hanya jika statusnya Completed
            'resolution_note' => 'required_if:status,Completed|nullable|string' 
        ]);

        $order = WorkOrder::findOrFail($id);
        $order->status = $request->status;

        // Jika WO diselesaikan, catat keterangan dan waktu selesainya
        if ($request->status === 'Completed') {
            $order->resolution_note = $request->resolution_note;
            
            // Catat waktu selesai hanya jika sebelumnya belum pernah dicatat
            if (!$order->completed_at) {
                $order->completed_at = \Carbon\Carbon::now();
            }
        } else {
            // Jika status dikembalikan ke Pending/Progress, kosongkan waktu dan catatan
            $order->completed_at = null;
            $order->resolution_note = null;
        }

        $order->save();

        return redirect()->back()->with('status', 'Status work order dan catatan berhasil diperbarui!');
    }

    // 5. Halaman Analisis Laporan (Web View)
    public function report(Request $request)
    {
        $query = \App\Models\WorkOrder::query();

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $workOrders = $query->get();

        $totalOrders = $workOrders->count();
        $completedOrders = $workOrders->where('status', 'Completed')->count();
        $onProgressOrders = $workOrders->where('status', 'On Progress')->count();
        $pendingOrders = $workOrders->where('status', 'Pending')->count();

        // ==========================================
        // LOGIKA HITUNG RATA-RATA DURASI PENGERJAAN
        // ==========================================
        $completedWithTime = $workOrders->where('status', 'Completed')->whereNotNull('completed_at');
        $totalMinutes = 0;
        
        foreach ($completedWithTime as $order) {
            $totalMinutes += \Carbon\Carbon::parse($order->created_at)->diffInMinutes(\Carbon\Carbon::parse($order->completed_at));
        }

        $avgResolutionTime = '0 Menit';
        if ($completedWithTime->count() > 0) {
            $avgMinutes = $totalMinutes / $completedWithTime->count();
            if ($avgMinutes >= 1440) {
                $avgResolutionTime = round($avgMinutes / 1440, 1) . " Hari";
            } elseif ($avgMinutes >= 60) {
                $avgResolutionTime = round($avgMinutes / 60, 1) . " Jam";
            } else {
                $avgResolutionTime = round($avgMinutes) . " Menit";
            }
        }
        // ==========================================

        $departmentStats = $workOrders->groupBy('department')->map->count();
        $issueStats = $workOrders->groupBy('issue_type')->map->count();

        return view('admin-report', compact(
            'totalOrders', 'completedOrders', 'onProgressOrders', 'pendingOrders',
            'departmentStats', 'issueStats', 'avgResolutionTime' // Kirim variabel baru ke view
        ));
    }

    // 6. Fitur Generate & Download PDF Laporan
    public function downloadPdf(Request $request)
    {
        $filters = $request->only(['from_date', 'to_date']);
        
        $query = WorkOrder::query();
        
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [$request->from_date, $request->to_date . ' 23:59:59']);
        }

        $workOrders = $query->get();

        $data = [
            'filters' => $filters,
            'totalOrders' => $workOrders->count(),
            'pendingOrders' => $workOrders->where('status', 'Pending')->count(),
            'onProgressOrders' => $workOrders->where('status', 'On Progress')->count(),
            'completedOrders' => $workOrders->where('status', 'Completed')->count(),
            'departmentStats' => $workOrders->groupBy('department')->map->count(),
            'issueStats' => $workOrders->groupBy('issue_type')->map->count(),
        ];

        // Load template khusus PDF dari resources/views/pdf/report.blade.php
        $pdf = Pdf::loadView('pdf.report', $data)->setPaper('a4', 'portrait');
        
        $fileName = 'Laporan_Work_Order_' . date('Ymd_His') . '.pdf';
        return $pdf->download($fileName);
    }
}