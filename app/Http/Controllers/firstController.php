<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Genre;
use App\Models\orders;
use Illuminate\Http\Request;

class firstController extends Controller
{

    // to show home page

    public function home()
    {


        // get the genre whi
        $genres = Genre::with(["getBooks" => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])
            ->whereHas("getBooks")
            ->get();


        // get the most ordered book

        $mostOrderedBook = Books::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->first();






        return view('userFolder.index', compact("genres", "mostOrderedBook"));
    }
}
