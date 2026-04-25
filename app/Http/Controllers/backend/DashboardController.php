<?php

namespace App\Http\Controllers\Backend; // ← Backend হবে

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('backend.dashboardIndex'); // ← backend folder
    }
}