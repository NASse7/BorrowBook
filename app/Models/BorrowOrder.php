<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowOrder extends Model
{
    protected $fillable = ['user_id', 'handled_by', 'status', 'payment_status', 'payment_info', 'latitude', 'longitude', 'address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
    public function notifications()
    {
        return $this->hasMany(AppNotification::class, 'order_id');
    }
}
