<?php

use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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

Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/orders', [AdminController::class, 'orders']);
Route::get('/admin/order/{id}', [AdminController::class, 'show']);
Route::post('/admin/order/{id}/update-status', [AdminController::class, 'updateStatus']);
Route::get('/admin/report', [AdminController::class, 'report']);
Route::get('/admin/report/pdf', [AdminController::class, 'downloadPdf']);
Route::get('/admin/order/{id}/pdf', [AdminController::class, 'downloadWorkOrderPdf']);

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
        'location' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Maksimal 5MB
    ]);

    // Jika pengguna mengunggah foto, simpan ke folder 'storage/app/public/work_orders'
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('work_orders', 'public');
    }

    $workOrder = WorkOrder::create($data);

    $whatsappNumber = env('ADMIN_WHATSAPP_NUMBER', '62812345678');
    $message = "Halo Admin, saya telah membuat work order baru:\n\nNomor WO: {$workOrder->wo_number}\nDepartemen: {$workOrder->department}\nLokasi: {$workOrder->location}\nJenis Masalah: {$workOrder->issue_type}\nDeskripsi: {$workOrder->description}\n\nSilakan lihat detail di dashboard. Terima kasih!";
    $whatsappUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($message);

    return redirect($whatsappUrl);
});