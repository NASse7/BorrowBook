<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['category_id', 'added_by', 'title', 'author', 'quantity', 'price', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function scopeSearch($q, ?string $term)
    {
        return $term ? $q->where(fn($w) => $w
            ->where('title', 'like', "%$term%")
            ->orWhere('author', 'like', "%$term%")
            ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%$term%"))) : $q;
    }
}
