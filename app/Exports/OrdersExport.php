<?php
namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    ShouldAutoSize
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Order::with(['user', 'table'])->latest();

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=',
                             $this->filters['date_from']);
        }
        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=',
                             $this->filters['date_to']);
        }

        return $query->get()->map(function ($order) {
            return [
                'ID'             => '#'.$order->id,
                'Customer'       => $order->user->name ?? 'Guest',
                'Table'          => $order->table
                                    ? 'Table #'.$order->table->table_number
                                    : 'Takeaway',
                'Type'           => ucfirst(str_replace('_', ' ',
                                            $order->order_type)),
                'Items'          => $order->orderItems()->count(),
                'Total (Rs.)'    => number_format($order->total_amount, 0),
                'Payment Status' => ucfirst($order->payment_status),
                'Payment Method' => ucfirst($order->payment_method),
                'Order Status'   => ucfirst($order->status),
                'Date'           => $order->created_at
                                         ->format('d M Y, h:i A'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID', 'Customer', 'Table', 'Type',
            'Items', 'Total (Rs.)', 'Payment Status',
            'Payment Method', 'Order Status', 'Date'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'C8A951'],
                ],
                'font' => [
                    'bold'  => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
            ],
        ];
    }
}