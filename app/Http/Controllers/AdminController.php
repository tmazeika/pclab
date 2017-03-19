<?php

namespace PCForge\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin');
    }

    public function create(string $table, int $id)
    {

    }

    public function update(string $table, int $id)
    {

    }

    public function delete(string $table, int $id)
    {
        try {
            DB::table($table)->where('id', $id)->delete();
        }
        catch (QueryException $e) {
            abort(400, $e->getMessage());
        }

        return redirect()->back();
    }
}
