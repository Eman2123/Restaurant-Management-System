<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'table_id', 'order_type', 'status',
        'payment_status', 'payment_method', 'total_amount', 'notes'
    ];
    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }
    public function user() { return $this->belongsTo(User::class); }
    public function table() { return $this->belongsTo(Table::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }
}