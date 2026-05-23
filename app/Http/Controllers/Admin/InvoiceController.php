<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function show(Order $order)
    {
        $order->load(['user', 'table', 'orderItems.menuItem']);
        return view('admin.invoice', compact('order'));
    }

    public function download(Order $order)
    {
        $order->load(['user', 'table', 'orderItems.menuItem']);
        $pdf = Pdf::loadView('admin.invoice', compact('order'))
                  ->setPaper([0, 0, 226.77, 566.93]);
        return $pdf->download('invoice-'.$order->id.'.pdf');
    }
}