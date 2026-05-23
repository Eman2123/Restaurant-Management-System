<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function create()
    {
        $tables = Table::where('status', 'available')->get();
        return view('customer.reservation', compact('tables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guest_name'       => 'required|string|max:255',
            'guest_phone'      => 'required|string|max:20',
            'guest_email'      => 'nullable|email',
            'table_id'         => 'required|exists:tables,id',
            'reservation_date' => 'required|date|after:today',
            'reservation_time' => 'required',
            'guests_count'     => 'required|integer|min:1',
        ]);

        Reservation::create([
            'user_id'          => auth()->id(),
            'guest_name'       => $request->guest_name,
            'guest_phone'      => $request->guest_phone,
            'guest_email'      => $request->guest_email,
            'table_id'         => $request->table_id,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'guests_count'     => $request->guests_count,
            'notes'            => $request->notes,
            'status'           => 'pending',
        ]);

        return redirect()->route('customer.reservations')
               ->with('success', 'Reservation booked successfully!');
    }

    public function myReservations()
    {
        $reservations = Reservation::where('user_id', auth()->id())
                        ->with('table')
                        ->latest()->get();
        return view('customer.my-reservations', compact('reservations'));
    }

    public function cancel(Reservation $reservation)
    {
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        if ($reservation->status === 'pending') {
            $reservation->update(['status' => 'cancelled']);
            return back()->with('success',
                'Reservation cancelled successfully.');
        }

        return back()->with('error',
            'Only pending reservations can be cancelled.');
    }
}