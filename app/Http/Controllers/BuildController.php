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
            'selected'     => 'required|boolean',
        ]);

        $componentId = intval($request->input('component-id'));
        $selected = boolval($request->input('selected'));

        if ($selected) {
            if (!$compatibilityService->isAllowedToSelect($componentId)) {
                abort(400, 'Component Not Selectable');
            }

            $incompatibleIds = $compatibilityService->select($componentId);
        }
        else {
            $incompatibleIds = $compatibilityService->deselect($componentId);
        }

        return json_encode([($selected ? 'disable' : 'enable') => $incompatibleIds]);
    }
}
