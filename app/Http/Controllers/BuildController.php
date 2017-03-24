<?php

namespace PCForge\Http\Controllers;

use Illuminate\Http\Request;

class BuildController extends Controller
{
    public function index()
    {
        return view('build.index');
    }

    public function showCustom()
    {
        return view('build.custom');
    }

    public function showPreset()
    {
        return view('build.preset');
    }
}
