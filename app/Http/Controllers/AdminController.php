<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    // to open home page

    public function adminHome()
    {
        return view('adminFolder.home');
    }


    public function viewCustomers(Request $request)
    {
        if ($request->ajax()) {
            $customers = User::where("role", "user")->get(); // Fetch only required columns
            return DataTables::of($customers)->make(true); // Return JSON response for DataTables
        }

        return view("adminFolder.viewCustomer"); // Load the Blade view for non-AJAX requests
    }

    public function viewSuppliers(Request $request)
    {


        if ($request->ajax()) {
            $customers = User::where("role", "supplier")->get(); // Fetch only required columns
            return DataTables::of($customers)->make(true); // Return JSON response for DataTables
        }

        return view("adminFolder.viewSupplier"); // Load the Blade view for non-AJAX requests
    }



    // to show categoris

    public function viewCategory()
    {
        return view("adminFolder.view_category");
    }
}
