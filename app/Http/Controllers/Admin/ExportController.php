<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Reservation;
use App\Exports\OrdersExport;
use App\Exports\ReservationsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    // ── Orders Excel
    public function ordersExcel(Request $request)
    {
        $filters = $request->only(['status','date_from','date_to']);
        $filename = 'orders-'.now()->format('Y-m-d').'.xlsx';
        return Excel::download(new OrdersExport($filters), $filename);
    }

    // ── Orders PDF
    public function ordersPdf(Request $request)
    {
        $query = Order::with(['user','table','orderItems'])
                      ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders  = $query->get();
        $filters = $request->only(['status','date_from','date_to']);

        $pdf = Pdf::loadView('admin.pdf.orders',
                              compact('orders','filters'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('orders-'.now()->format('Y-m-d').'.pdf');
    }

    // ── Reservations Excel
    public function reservationsExcel()
    {
        return Excel::download(
            new ReservationsExport(),
            'reservations-'.now()->format('Y-m-d').'.xlsx'
        );
    }

    // ── Reservations PDF
    public function reservationsPdf()
    {
        $reservations = Reservation::with(['table','user'])
                        ->latest()->get();

        $pdf = Pdf::loadView('admin.pdf.reservations',
                              compact('reservations'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download(
            'reservations-'.now()->format('Y-m-d').'.pdf'
        );
    }
}