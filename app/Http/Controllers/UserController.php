<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\cart;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;
use Symfony\Component\CssSelector\Node\FunctionNode;

class UserController extends Controller
{
    //


    public function userHome()
    {

        $genres = Genre::with(["getBooks" => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])
            ->whereHas("getBooks")
            ->get();
        return view('userFolder.index', compact('genres'));
    }
    public function addToCart($id)
    {
        $exist_pro = cart::where("user_id", auth()->user()->id)
            ->where("books_id", $id)->first();

        if ($exist_pro) {
            $exist_pro->quantity += 1;
            $exist_pro->save();
        } else {
            $new = new cart();

            $new->books_id = $id;
            $new->user_id = Auth::user()->id;
            $new->save();
        }

        return redirect()->route("cart")->with("success", "Item has been added");
    }

    public function userProfile()
    {

        return view('userFolder.user_profile');
    }

    public function cart()
    {

        $cart = cart::with("books")->where("user_id", auth()->user()->id)->get();

        return view('userFolder.cart', compact("cart"));
    }
}
