<?php

use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $query = WorkOrder::orderBy('created_at', 'desc');

    if ($request->filled('department')) {
        $query->where('department', $request->input('department'));
    }

    if ($request->filled('issue_type')) {
        $query->where('issue_type', $request->input('issue_type'));
    }

    if ($request->filled('status')) {
        $query->where('status', $request->input('status'));
    }

    if ($request->filled('from_date')) {
        $query->whereDate('created_at', '>=', $request->input('from_date'));
    }

    if ($request->filled('to_date')) {
        $query->whereDate('created_at', '<=', $request->input('to_date'));
    }

    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($sub) use ($search) {
            $sub->where('wo_number', 'like', "%{$search}%")
                ->orWhere('department', 'like', "%{$search}%")
                ->orWhere('issue_type', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }

    $workOrders = $query->get();

    return view('dashboard', [
        'workOrders' => $workOrders,
        'filters' => $request->only(['department', 'issue_type', 'status', 'search', 'from_date', 'to_date']),
    ]);
});

Route::get('/admin', function () {
    $workOrders = WorkOrder::all();

    return view('admin', [
        'workOrders' => $workOrders,
    ]);
});

Route::get('/admin/orders', function (Request $request) {
    $query = WorkOrder::orderBy('created_at', 'desc');

    if ($request->filled('department')) {
        $query->where('department', $request->input('department'));
    }

    if ($request->filled('issue_type')) {
        $query->where('issue_type', $request->input('issue_type'));
    }

    if ($request->filled('status')) {
        $query->where('status', $request->input('status'));
    }

    if ($request->filled('from_date')) {
        $query->whereDate('created_at', '>=', $request->input('from_date'));
    }

    if ($request->filled('to_date')) {
        $query->whereDate('created_at', '<=', $request->input('to_date'));
    }

    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($sub) use ($search) {
            $sub->where('wo_number', 'like', "%{$search}%")
                ->orWhere('department', 'like', "%{$search}%")
                ->orWhere('issue_type', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }

    $workOrders = $query->get();

    return view('admin-orders', [
        'workOrders' => $workOrders,
        'filters' => $request->only(['department', 'issue_type', 'status', 'search', 'from_date', 'to_date']),
    ]);
});

Route::get('/admin/order/{order}', function (WorkOrder $order) {
    return view('admin-detail', ['order' => $order]);
});

Route::post('/admin/order/{order}/update-status', function (Request $request, WorkOrder $order) {
    $data = $request->validate([
        'status' => 'required|in:Pending,On Progress,Completed',
    ]);

    $order->status = $data['status'];
    $order->save();

    return redirect("/admin/order/{$order->id}")->with('status', 'Status work order berhasil diperbarui.');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/add', function () {
    return view('add');
});

Route::post('/add', function (Request $request) {
    $data = $request->validate([
        'department' => 'required|in:FB Kitchen,Housekeeping,Front Office,DT,FB Service,P&C,Security,Sales,Acct,A&G',
        'issue_type' => 'required|in:ELECTRICAL,MECHANICAL,PLUMBING,HVAC,BUILDING,FURNITURE,AV,SAFETY,OTHER',
        'description' => 'nullable|string',
    ]);

    $workOrder = WorkOrder::create($data);

    $whatsappNumber = env('ADMIN_WHATSAPP_NUMBER', '62812345678');
    $message = "Halo Admin, saya telah membuat work order baru:\n\nNomor WO: {$workOrder->wo_number}\nDepartemen: {$workOrder->department}\nJenis Masalah: {$workOrder->issue_type}\nDeskripsi: {$workOrder->description}\n\nSilakan lihat detail di dashboard. Terima kasih!";
    $whatsappUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($message);

    return redirect($whatsappUrl);
});
