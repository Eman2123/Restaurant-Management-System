<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\MenuController as CustomerMenuController;
use App\Http\Controllers\Customer\ReservationController as CustomerReservationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboard;
use App\Http\Controllers\Staff\OrderController as StaffOrderController;

// ─── Customer / Public Routes ────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [CustomerMenuController::class, 'index'])->name('menu');
Route::get('/menu/{menuItem}', [CustomerMenuController::class, 'show'])->name('menu.show');
Route::get('/reservation', [CustomerReservationController::class, 'create'])->name('reservation.create');
Route::post('/reservation', [CustomerReservationController::class, 'store'])->name('reservation.store');

// ─── Auth Routes ──────────────────────────────────────────
require __DIR__.'/auth.php';

// ─── Redirect after login ─────────────────────────────────
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') return redirect()->route('admin.dashboard');
    if ($user->role === 'staff') return redirect()->route('staff.dashboard');
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

// ─── Admin Routes ─────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('menu', MenuController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('reservations', ReservationController::class);
    Route::resource('tables', TableController::class);
    Route::resource('users', UserController::class);
    Route::get('tables/{table}/qrcode',
    [\App\Http\Controllers\Admin\TableController::class, 'qrcode'])
    ->name('tables.qrcode');
    Route::patch('orders/{order}/waiter',
    [\App\Http\Controllers\Admin\OrderController::class, 'assignWaiter'])
    ->name('orders.waiter');

    // Reviews Management
    Route::get('reviews',
        [\App\Http\Controllers\Admin\ReviewController::class, 'index'])
        ->name('reviews.index');
    Route::delete('reviews/{review}',
        [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])
        ->name('reviews.destroy');

    // Settings Management
    Route::get('settings',
        [\App\Http\Controllers\Admin\SettingController::class, 'index'])
        ->name('settings');
    Route::post('settings',
        [\App\Http\Controllers\Admin\SettingController::class, 'update'])
        ->name('settings.update');

    // Cache Clear (Settings Related)
    Route::get('settings/cache/clear', function() {
        \Artisan::call('cache:clear');
        \Artisan::call('view:clear');
        \Artisan::call('route:clear');
        return redirect()->route('admin.settings')
               ->with('success', 'Cache cleared successfully!');
    })->name('settings.cache.clear');

    // Coupons
    Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);
    Route::patch('coupons/{coupon}/toggle',
        [\App\Http\Controllers\Admin\CouponController::class, 'toggle'])
        ->name('coupons.toggle');

    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::patch('orders/{order}/payment', [OrderController::class, 'updatePayment'])->name('orders.payment');

    Route::get('export/orders-excel',
        [\App\Http\Controllers\Admin\ExportController::class, 'ordersExcel'])
        ->name('export.orders.excel');
    Route::get('export/orders-pdf',
        [\App\Http\Controllers\Admin\ExportController::class, 'ordersPdf'])
        ->name('export.orders.pdf');
    Route::get('export/reservations-excel',
        [\App\Http\Controllers\Admin\ExportController::class, 'reservationsExcel'])
        ->name('export.reservations.excel');
    Route::get('export/reservations-pdf',
        [\App\Http\Controllers\Admin\ExportController::class, 'reservationsPdf'])
        ->name('export.reservations.pdf');

    Route::get('reports', [ReportController::class, 'index'])->name('reports');
    Route::get('reports/daily',
        [\App\Http\Controllers\Admin\ReportController::class, 'daily'])
        ->name('reports.daily');
        
    Route::get('orders/{order}/invoice',
        [\App\Http\Controllers\Admin\InvoiceController::class, 'show'])
        ->name('orders.invoice');

    Route::get('orders/{order}/invoice/download',
        [\App\Http\Controllers\Admin\InvoiceController::class, 'download'])
        ->name('orders.invoice.download');
});

// ─── Staff Routes ─────────────────────────────────────────
Route::prefix('staff')->name('staff.')->middleware(['auth', 'staff'])->group(function () {
    
    Route::get('/dashboard', [StaffDashboard::class, 'index'])->name('dashboard');

    // Live Orders
    Route::get('/orders', [StaffOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/status', [StaffOrderController::class, 'updateStatus'])->name('orders.status');

    // Kitchen Display Routes
    Route::get('/kitchen', [\App\Http\Controllers\Staff\KitchenController::class, 'index'])
        ->name('kitchen');

    Route::patch('/kitchen/{order}/status', [\App\Http\Controllers\Staff\KitchenController::class, 'updateStatus'])
        ->name('kitchen.status');

    Route::get('/kitchen/live-orders', [\App\Http\Controllers\Staff\KitchenController::class, 'liveOrders'])
        ->name('kitchen.live');
});

// ─── Customer Routes ──────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders', [\App\Http\Controllers\Customer\OrderController::class, 'index'])->name('customer.orders');
    Route::get('/my-orders/{order}', [\App\Http\Controllers\Customer\OrderController::class, 'show'])->name('customer.orders.show');

    // Review Routes
    Route::get('/orders/{order}/review',
        [\App\Http\Controllers\Customer\ReviewController::class, 'create'])
        ->name('customer.review.create');
    Route::post('/orders/{order}/review',
        [\App\Http\Controllers\Customer\ReviewController::class, 'store'])
        ->name('customer.review.store');

    // Order Creation
    Route::get('/order/create', [\App\Http\Controllers\Customer\OrderController::class, 'create'])->name('customer.order.create');
    Route::post('/order', [\App\Http\Controllers\Customer\OrderController::class, 'store'])->name('customer.order.store');
    
    // Apply Coupon
    Route::post('/apply-coupon',
        [\App\Http\Controllers\Customer\OrderController::class, 'applyCoupon'])
        ->name('coupon.apply');
        
    Route::get('/order/{order}/confirmation', [\App\Http\Controllers\Customer\OrderController::class, 'confirmation'])->name('customer.order.confirmation');

    // Reservations
    Route::get('/my-reservations', [CustomerReservationController::class, 'myReservations'])->name('customer.reservations');
    Route::post('/reservations/{reservation}/cancel', [CustomerReservationController::class, 'cancel'])->name('customer.reservations.cancel');
});

Route::get('/profile',
    [\App\Http\Controllers\Customer\ProfileController::class, 'edit'])
    ->name('customer.profile');
Route::post('/profile',
    [\App\Http\Controllers\Customer\ProfileController::class, 'update'])
    ->name('customer.profile.update');