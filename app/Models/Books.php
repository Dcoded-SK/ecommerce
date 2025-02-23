<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    protected $table = "books";

    public function getCart()
    {
        return $this->hasMany(cart::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function orders()
    {
        return $this->belongsToMany(orders::class, 'books_orders', 'book_Id', 'order_id');
    }
}
