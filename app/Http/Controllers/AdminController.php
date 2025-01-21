<?php

namespace App\Http\Controllers;

use App\Exports\GenreExport;
use App\Imports\GenreImport;
use App\Mail\OrderRegardMail;
use App\Models\Books;
use App\Models\Genre;
use App\Models\orders;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use PDO;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as ModelsRole;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    // to open home page

    public function adminHome(Request $request)
    {
        // Fetch all roles with permissions
        $roles = ModelsRole::with('permissions')->get();

        // Retrieve users and assign roles based on the 'role' column
        $users = User::all();  // Get all users
        foreach ($users as $user) {
            // Sync the role based on the 'role' column
            if ($user->role == 'user') {
                $user->syncRoles(['user']);
            } elseif ($user->role == 'supplier') {
                $user->syncRoles(['supplier']);
            } elseif ($user->role == 'admin') {
                $user->syncRoles(['admin']);
            }
        }

        ModelsRole::where("name", "admin")->first()->syncPermissions(Permission::all());


        $books = Books::limit(3)->orderBy("created_at", "desc")->get();


        $orders = orders::all();

        if ($request->ajax()) {
            return DataTables::of($orders)
                ->setRowClass(function ($row) {
                    return $row->status == "pending"
                        ? 'alert-warning'
                        : ($row->status == "cancel"
                            ? 'alert-danger'
                            : 'alert-success');
                })
                ->make(true);
        }


        // Pass roles to the view

        return view('adminFolder.home', compact('roles', 'books'));
    }




    // to return customers list
    public function viewCustomers(Request $request)
    {
        if ($request->ajax()) {
            $customers = User::where("role", "user")->get(); // Fetch only required columns
            return DataTables::of($customers)->make(true); // Return JSON response for DataTables
        }

        return view("adminFolder.viewCustomer"); // Load the Blade view for non-AJAX requests
    }

    // to return suppliers list
    public function viewSuppliers(Request $request)
    {


        if ($request->ajax()) {
            $customers = User::where("role", "supplier")->get(); // Fetch only required columns
            return DataTables::of($customers)->make(true); // Return JSON response for DataTables
        }

        return view("adminFolder.viewSupplier"); // Load the Blade view for non-AJAX requests
    }

    public function viewAdmins(Request $request)
    {
        if ($request->ajax()) {

            $customers = User::where("role", "admin")->get(); // Fetch only required columns
            return DataTables::of($customers)->make(true); // Return JSON response for DataTables
        }

        return view("adminFolder.viewAdmin");
    }



    // to show categoris

    public function viewGenre(Request $request)
    {

        if ($request->ajax()) {

            $genre = Genre::query();

            return DataTables::of($genre)->make(true);
        }
        return view("adminFolder.viewGenre");
    }

    // to add new genres using export

    public function newGenre(Request $request)
    {
        $request->validate([
            'genres' => 'required|mimes:xlsx,xls,html'
        ]);


        Excel::import(new GenreImport, $request['genres']);

        return redirect()->back()->with("success", "Genre has be recored");
    }


    // to download genre list
    public function exportGenre()
    {


        return Excel::download(new GenreExport, "Genre.xlsx");
    }


    // to assing permission to route

    public function assignPermissionsView($role)
    {

        $role = ModelsRole::where("name", $role)->first();

        $permissions = $role->permissions;
        $role = $role->name;

        $all_permissions = Permission::all();



        return view("adminFolder.assing_permission_roles", compact("permissions", "role", "all_permissions"));
    }

    public function assignPermissionsMethod(Request $request)
    {

        $role = ModelsRole::where("name", $request->role)->first();

        $role->syncPermissions($request->permissions);

        return redirect()->back()->with("success", "Permission assign permission successfully");
    }

    // to add books

    public function addBookView()
    {

        $genre = Genre::all();

        return view("adminFolder.add_book", compact("genre"));
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
        $insert->save();


        return redirect("view-books")->with("success", "New books has been added");
    }

    // to show the books

    public function viewBooks()
    {
        $books = Books::orderBy("created_at", "asc")->paginate(3);

        return view("adminFolder.view_books", compact("books"));
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
            $c_ord->save();

            $user = User::where("id", $c_ord->user_id)->first();

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

    // public function deleteOrder(Request $request)
    // {

    //     $reason = $request->input('reason'); // Retrieve the reason

    //     foreach ($request['order'] as $order) {
    //         # code...


    //         $c_ord = orders::where("id", $order)->first();



    //         $user = User::where("id", $c_ord->user_id)->first();

    //         $c_ord->delete();
    //         // // Prepare email data
    //         $data = [
    //             'subject' => 'Order Cancellation regard',
    //             'name' => $user->name, // Replace with dynamic user name if available
    //             'message' => $reason,
    //         ];

    //         // Send the cancellation email
    //         Mail::to('skohar098@rku.ac.in')->send(new OrderRegardMail($data));
    //     }
    //     return redirect()->back()->with("success", "Orders has been removed  successfully");
    // }

    // to show a book

    public function getBookDetails($id)
    {
        // Fetch the book by ID from the database
        $book = Books::find($id);

        // If the book exists, return it as JSON
        if ($book) {
            return response()->json(['book' => $book]);
        }

        // If not found, return a 404 error response
        return response()->json(['error' => 'Book not found'], 404);
    }
}
