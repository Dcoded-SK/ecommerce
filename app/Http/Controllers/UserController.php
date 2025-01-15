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


    public function book($id)
    {
        $book = Books::where("id", $id)->first();;

        return view('userFolder.view_product', compact('book'));
    }


    public function changeQuantity($id, $q)
    {
        if ($q < 1) {
            return redirect()->back()->with("error", "Item quantity must no be less than 1");
        } else {
            $quantity = cart::where("id", $id)->where("user_id", auth()->user()->id)->first();

            if ($quantity) {
                $quantity->quantity = $q;
                $quantity->save();
            }

            return redirect()->back();
        }
    }

    public function deleteCartItem($id)
    {
        $del = cart::where("id", $id)->where("user_id", auth()->user()->id)->first();
        if ($del) {
            $del->delete();
        }

        return redirect()->back();
    }

    public function checkout()
    {

        $cart_items = cart::where("user_id", auth()->user()->id)->get();
        return view('userFolder.checkout', compact("cart_items"));
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
