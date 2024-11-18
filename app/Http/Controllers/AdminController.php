<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }
        return view('admin.dashboard'); // Create this view file
    }
}
