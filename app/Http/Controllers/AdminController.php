<?php

namespace PCForge\Http\Controllers;

use Illuminate\Http\Request;
use PCForge\Events\ComponentModified;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
}
