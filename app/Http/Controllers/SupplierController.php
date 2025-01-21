<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Genre;
use App\Models\orders;
use App\Mail\OrderRegardMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    //


    public function supplierHome(Request $request)
    {

        // to pass the book 
        $books = Books::where("supplier_id", auth()->user()->id)->get();

        // to pass the orders
        $books_id = $books->pluck('id');
        $orders = orders::whereIn("book_id", $books_id)->get();

        if ($request->ajax()) {
            return DataTables::of($orders)->make(true);
        }
        return view('supplierFolder.home', compact('books'));
    }

    public function viewBooks()
    {
        $books = Books::where("supplier_id", auth()->user()->id)->get();
        return view("supplierFolder.view_books", compact("books"));
    }

    public function addBookView()
    {
        $genre = Genre::all();
        return view("supplierFolder.add_book", compact("genre"));
    }


    public function addBookMethod(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:30|unique:books,title',
            'author' => 'required|min:3|max:30',
            'genre' => 'required',
            'picture' => 'required|mimes:png,jpg,webp',
            'price' => 'required|'

        ]);

        $image = $request->picture;
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Move the file to the 'public/books_picture' directory
        $image->move(public_path('books_picture'), $imageName);


        $insert = new Books();

        $insert->title = $request['title'];
        $insert->author = $request['author'];
        $insert->genre_id = $request['genre'];
        $insert->picture = $imageName;
        $insert->price = $request['price'];
        $insert->supplier_id = auth()->user()->id;
        $insert->save();


        return redirect("supplier-view-books")->with("success", "New books has been added");
    }


    // to edit orders status

    public function confirmOrder(Request $request)
    {

        foreach ($request['order'] as $order) {
            # code...

            $c_ord = orders::where("id", $order)->first();

            $c_ord->status = "confirm";
            $c_ord->save();


            $user = User::where("id", $c_ord->user_id)->first();

            // // Prepare email data
            $data = [
                'subject' => 'Order Confirmation regard',
                'name' => $user->name, // Replace with dynamic user name if available
                'message' => 'Your order has been confirmed',
            ];

            // Send the cancellation email
            Mail::to($user->email)->send(new OrderRegardMail($data));
        }
        return redirect()->back()->with("success", "Orders status updated successfully");
    }

    public function cancelOrder(Request $request)
    {

        $reason = $request->input('reason'); // Retrieve the reason

        foreach ($request['order'] as $order) {
            # code...


            $c_ord = orders::where("id", $order)->first();

            $c_ord->status = "cancel";

            $user = User::where("id", $c_ord->user_id)->first();

            $c_ord->save();


            // // Prepare email data
            $data = [
                'subject' => 'Order Cancellation regard',
                'name' => $user->name, // Replace with dynamic user name if available
                'message' => $reason,
            ];

            // Send the cancellation email
            Mail::to($user->email)->send(new OrderRegardMail($data));
        }
        return redirect()->back()->with("success", "Orders status updated successfully");
    }
}
