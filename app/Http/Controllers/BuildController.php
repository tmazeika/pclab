<?php

namespace PCForge\Http\Controllers;

use Illuminate\Http\Request;
use PCForge\Contracts\CompatibilityServiceContract;

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

    public function customSelect(Request $request, CompatibilityServiceContract $compatibilityService)
    {
        $this->validate($request, [
            'component-id' => 'required|exists:components,id',
            'count'        => 'required|integer|min:0',
        ]);

        $id = intval($request->input('component-id'));
        $count = intval($request->input('count'));

        if (!$compatibilityService->isAllowed($id, $count)) {
            abort(400, 'Component not selectable');
        }

        return json_encode([
            ($count === 0 ? 'enable' : 'disable') => $compatibilityService->select($id, $count),
        ]);
    }
}
