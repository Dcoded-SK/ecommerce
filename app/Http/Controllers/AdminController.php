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
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as ModelsRole;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    // Open the admin home page
    public function adminHome(Request $request)
    {
        $roles = ModelsRole::with('permissions')->get(); // Fetch all roles with permissions

        // Sync roles for users based on the 'role' column
        $users = User::all();
        foreach ($users as $user) {
            if ($user->role == 'user') {
                $user->syncRoles(['user']);
            } elseif ($user->role == 'supplier') {
                $user->syncRoles(['supplier']);
            } elseif ($user->role == 'admin') {
                $user->syncRoles(['admin']);
            }
        }

        // Grant all permissions to the admin role
        ModelsRole::where("name", "admin")->first()->syncPermissions(Permission::all());

        // Fetch the latest 3 books
        $books = Books::limit(3)->orderBy("created_at", "desc")->get();

        $orders = orders::all();

        // Return data in JSON format for AJAX requests
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

        return view('adminFolder.home', compact('roles', 'books'));
    }

    // Display customers list
    public function viewCustomers(Request $request)
    {
        if ($request->ajax()) {
            $customers = User::where("role", "user")->get();
            return DataTables::of($customers)->make(true);
        }

        return view("adminFolder.viewCustomer");
    }

    // Display suppliers list
    public function viewSuppliers(Request $request)
    {
        if ($request->ajax()) {
            $customers = User::where("role", "supplier")->get();
            return DataTables::of($customers)->make(true);
        }

        return view("adminFolder.viewSupplier");
    }

    // Display admins list
    public function viewAdmins(Request $request)
    {
        if ($request->ajax()) {
            $customers = User::where("role", "admin")->get();
            return DataTables::of($customers)->make(true);
        }

        return view("adminFolder.viewAdmin");
    }

    // Display genres
    public function viewGenre(Request $request)
    {
        if ($request->ajax()) {
            $genre = Genre::query();
            return DataTables::of($genre)->make(true);
        }
        return view("adminFolder.viewGenre");
    }

    // Add new genres using import
    public function newGenre(Request $request)
    {
        $request->validate([
            'genres' => 'required|mimes:xlsx,xls,html'
        ]);

        Excel::import(new GenreImport, $request['genres']);

        return redirect()->back()->with("success", "Genre has been recorded");
    }

    // Export the genre list
    public function exportGenre()
    {
        return Excel::download(new GenreExport, "Genre.xlsx");
    }

    // Assign permissions view
    public function assignPermissionsView($role)
    {
        $role = ModelsRole::where("name", $role)->first();
        $permissions = $role->permissions;
        $all_permissions = Permission::all();

        return view("adminFolder.assing_permission_roles", compact("permissions", "role", "all_permissions"));
    }

    // Assign permissions to a role
    public function assignPermissionsMethod(Request $request)
    {
        $role = ModelsRole::where("name", $request->role)->first();
        $role->syncPermissions($request->permissions);

        return redirect()->back()->with("success", "Permissions assigned successfully");
    }

    // Show the form to add a book
    public function addBookView()
    {
        $genre = Genre::all();
        return view("adminFolder.add_book", compact("genre"));
    }

    // Add a new book
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
        $image->move(public_path('books_picture'), $imageName);

        $insert = new Books();
        $insert->title = $request['title'];
        $insert->author = $request['author'];
        $insert->genre_id = $request['genre'];
        $insert->picture = $imageName;
        $insert->price = $request['price'];
        $insert->save();

        return redirect("view-books")->with("success", "New book has been added");
    }

    // Show the list of books
    public function viewBooks()
    {
        $books = Books::orderBy("created_at", "asc")->paginate(3);
        return view("adminFolder.view_books", compact("books"));
    }

    // Confirm order status and send email
    public function confirmOrder(Request $request)
    {
        foreach ($request['order'] as $order) {
            $c_ord = orders::where("id", $order)->first();
            $c_ord->status = "confirm";
            $c_ord->save();

            $user = User::where("id", $c_ord->user_id)->first();

            $data = [
                'subject' => 'Order Confirmation regard',
                'name' => $user->name,
                'message' => 'Your order has been confirmed',
            ];

            Mail::to($user->email)->send(new OrderRegardMail($data));
        }
        return redirect()->back()->with("success", "Order status updated successfully");
    }

    // Cancel order and send email with reason
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

    // Get book details by ID
    public function getBookDetails($id)
    {
        $book = Books::find($id);
        if ($book) {
            return response()->json(['book' => $book]);
        }

        return response()->json(['error' => 'Book not found'], 404);
    }
}
