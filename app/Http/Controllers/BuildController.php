<?php

namespace PCForge\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
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
            'component-id'   => 'required|exists:components,id',
            'component-type' => 'required|in:chassis,cooling,graphics,memory,motherboard,power,processor,storage',
            'selected'       => 'required|boolean',
        ]);

        $componentId = intval($request->input('component-id'));
        $componentType = $request->input('component-type');
        $selected = boolval($request->input('selected'));

        if ($selected) {
            if (!$compatibilityService->isAllowedToSelect($componentId)) {
                abort(400, 'Component Not Selectable');
            }

            $otherIds = $compatibilityService->select($componentId, $componentType);
        }
        else {
            $otherIds = $compatibilityService->deselect($componentId, $componentType);
        }

        session(["$componentId.selected" => $selected]);

        return json_encode([$selected ? 'disable' : 'enable' => $otherIds]);
    }
}
