<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    use HasFactory;

    public function books()
    {
        return $this->belongsToMany(Books::class, 'books_orders');
    }


    public function bill()
    {
        return $this->hasOne(bill::class);
    }
}