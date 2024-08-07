<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ClearDatabaseController extends Controller
{
    function index() : View {
        return view('admin.clear-database.index');
    }

    function clearDB() {
        dd('working');
    }
}
