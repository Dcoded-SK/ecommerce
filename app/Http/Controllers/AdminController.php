<?php

namespace App\Http\Controllers;

use App\Exports\GenreExport;
use App\Imports\GenreImport;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDO;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    // to open home page

    public function adminHome()
    {
        return view('adminFolder.home');
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

    public function exportGenre()
    {
        return Excel::download(new GenreExport, "Genre.xlsx");
    }
}
