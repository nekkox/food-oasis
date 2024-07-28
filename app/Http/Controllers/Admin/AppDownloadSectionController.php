<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppDownloadSectionController extends Controller
{
    public function index(){
        return view('admin.app-download-section.index');
    }
}
