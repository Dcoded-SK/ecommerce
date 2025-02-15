<?php

namespace App\Http\Controllers;

use App\Models\bill;
use App\Models\cart;
use App\Models\User;
use App\Models\Books;
use App\Models\Genre;
use App\Models\orders;
use FontLib\Table\Type\name;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Jobs\SendNotificationJob;
use PhpParser\Node\Stmt\Foreach_;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;
use Symfony\Component\CssSelector\Node\FunctionNode;

class UserController extends Controller
{
    //


    public function __construct()
    {
        dispatch(new SendNotificationJob("Hi, You are notified using queue"));
    }

    public function userHome()
    {

        $genres = Genre::with(["getBooks" => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])
            ->whereHas("getBooks")
            ->get();

        $mostOrderedBook = Books::withCount("orders")->orderBy("orders_count", "desc")->first();

        return view('userFolder.index', compact('genres', 'mostOrderedBook'));
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

        $orders = orders::where("user_id", auth()->user()->id)->get();



        $user_add = auth()->user();

        foreach ($orders as $user) {
            # code...
            if ($user->bill) {
                $user_add = $user->bill;
            }
        }






        return view('userFolder.checkout', compact("cart_items", "user_add"));
    }

    public function checkoutKaro(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:30',
            'contact_number' => 'required|numeric|min:10',
            'email' => 'required|email',
            'address' => 'required|min:5',
            'country' => 'required',
            'state' => 'required',
            'pin_code' => 'required|max:6|min:6'
        ]);

        $cart_items = cart::where("user_id", auth()->user()->id)->get();
        $order_ids = [];

        foreach ($cart_items as $cart) {
            $create_order = new orders();

            // Create the order
            $create_order->user_id = auth()->user()->id;
            $create_order->quantity = $cart->quantity;
            $create_order->book_id = $cart->books->id;
            $create_order->total_price = $cart->quantity * $cart->books->price;
            $create_order->payment_method = $request['payment_method'];
            $create_order->save();

            // Attach the book to the order using the pivot table
            $create_order->books()->attach($cart->books->id);




            // Save the billing address of each orders
            $bill_add = new bill();
            $bill_add->order_id = $create_order->id;
            $bill_add->name = $request['name'];
            $bill_add->email = $request['email'];
            $bill_add->address = $request['address'];
            $bill_add->country = $request['country'];
            $bill_add->contact = $request['contact_number'];
            $bill_add->state = $request['state'];
            $bill_add->pin_code = $request['pin_code'];
            $bill_add->save();

            // Delete the cart item
            $cart->delete();
        }





        return redirect()->route("user-profile");
    }

    public function userProfile()
    {

        $orders = orders::where("user_id", auth()->user()->id)->get();




        return view('userFolder.user_profile', compact('orders'));
    }

    public function cart()
    {

        $cart = cart::with("books")->where("user_id", auth()->user()->id)->get();

        return view('userFolder.cart', compact("cart"));
    }

    public function downloadInvoie($id)
    {

        $order = orders::find($id);

        $book_detail = Books::find($order->book_id);

        $pdf = PDF::loadView('invoice', ['order_data' => $order, 'book' => $book_detail])->setPaper('A4', 'portrait');
        return $pdf->download('invoice-' . $id . '.pdf');
    }


    public function orderRating(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|min:1'
        ]);

        $order = orders::find($id);

        $book = $order->books()->first();

        $order->rating = $request['rating'];
        $order->save();

        $book->ratings = $request['rating'];
        $book->save();
    }
}
