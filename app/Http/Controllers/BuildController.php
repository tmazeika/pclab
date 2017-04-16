<?php

namespace PCForge\Http\Controllers;

use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Http\Requests\SelectComponent;

class BuildController extends Controller
{
    public function index(ComponentRepositoryContract $componentRepo)
    {
        $components = $componentRepo->buildGroupedReachable();

        return view('build.index', compact('components'));
    }

    public function select(SelectComponent $request)
    {
        return response()->json([
            'disable' => [/* TODO */],
        ]);
    }
}
