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
        return view('admin', compact('workOrders'));
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

        $workOrders = $query->orderBy('created_at', 'desc')->get();

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
            'status' => 'required|in:Pending,On Progress,Completed'
        ]);

        $order = WorkOrder::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('status', 'Status work order berhasil diperbarui!');
    }

    // 5. Halaman Analisis Laporan (Web View)
    public function report(Request $request)
    {
        $filters = $request->only(['from_date', 'to_date']);
        
        $query = WorkOrder::query();
        
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [$request->from_date, $request->to_date . ' 23:59:59']);
        }

        $workOrders = $query->get();

        // Kalkulasi data statistik untuk card
        $totalOrders = $workOrders->count();
        $pendingOrders = $workOrders->where('status', 'Pending')->count();
        $onProgressOrders = $workOrders->where('status', 'On Progress')->count();
        $completedOrders = $workOrders->where('status', 'Completed')->count();

        // Kalkulasi statistik untuk diagram batang (Group By)
        $departmentStats = $workOrders->groupBy('department')->map->count();
        $issueStats = $workOrders->groupBy('issue_type')->map->count();

        return view('admin-report', compact(
            'filters', 'totalOrders', 'pendingOrders', 'onProgressOrders', 
            'completedOrders', 'departmentStats', 'issueStats'
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