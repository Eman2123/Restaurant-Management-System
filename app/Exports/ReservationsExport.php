<?php
namespace App\Exports;

use App\Models\Reservation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReservationsExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    ShouldAutoSize
{
    public function collection()
    {
        return Reservation::with(['table', 'user'])
            ->latest()->get()->map(function ($res) {
                return [
                    'ID'       => '#'.$res->id,
                    'Guest'    => $res->guest_name,
                    'Phone'    => $res->guest_phone,
                    'Email'    => $res->guest_email ?? '—',
                    'Table'    => 'Table #'.$res->table->table_number,
                    'Date'     => $res->reservation_date,
                    'Time'     => $res->reservation_time,
                    'Guests'   => $res->guests_count,
                    'Status'   => ucfirst($res->status),
                    'Notes'    => $res->notes ?? '—',
                    'Booked'   => $res->created_at->format('d M Y'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID', 'Guest Name', 'Phone', 'Email',
            'Table', 'Date', 'Time', 'Guests',
            'Status', 'Notes', 'Booked At'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold'  => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'C8A951'],
                ],
            ],
        ];
    }
}