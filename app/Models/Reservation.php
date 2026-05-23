<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'table_id', 'guest_name', 'guest_phone',
        'guest_email', 'reservation_date', 'reservation_time',
        'guests_count', 'status', 'notes'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function table() { return $this->belongsTo(Table::class); }
}