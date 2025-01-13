<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Genre;
use Illuminate\Http\Request;

class firstController extends Controller
{

    // to show home page

    public function home()
    {

        $genres = Genre::with(["getBooks" => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])
            ->whereHas("getBooks")
            ->get();
        return view('userFolder.index', compact("genres"));
    }
}
