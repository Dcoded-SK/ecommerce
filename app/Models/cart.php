<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    use HasFactory;

    protected $table = "carts";

    public function books()
    {
        return $this->belongsTo(Books::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
