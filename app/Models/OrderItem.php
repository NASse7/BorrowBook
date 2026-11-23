<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;
    protected $fillable = ['order_id', 'book_id', 'quantity', 'return_date'];
    protected function casts(): array
    {
        return ['return_date' => 'date'];
    }

    public function order()
    {
        return $this->belongsTo(BorrowOrder::class, 'order_id');
    }
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
