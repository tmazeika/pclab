<?php

namespace PCForge\Http\Controllers;

use PCForge\Contracts\ComponentCompatibilityServiceContract;
use PCForge\Contracts\ComponentDisabledServiceContract;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Contracts\ComponentSelectionServiceContract;
use PCForge\Http\Requests\SelectComponent;
use PCForge\Models\Component;

class BuildController extends Controller
{
    public function index(ComponentRepositoryContract $componentRepo)
    {
        $components = $componentRepo->buildGroupedReachable();

        return view('build.index', compact('components'));
    }

    public function select(ComponentCompatibilityServiceContract $compatibilityService,
                           ComponentDisabledServiceContract $componentDisabledServiceContract,
                           ComponentSelectionServiceContract $componentSelectionService,
                           SelectComponent $request)
    {
        $component = Component::find($request->input('id'));
        $componentSelectionService->select($component->child(), $request->input('count'));
        $incompatibilities = $compatibilityService->computeIncompatibilities();
        $componentDisabledServiceContract->setDisabled($incompatibilities);

        return response()->json([
            'disable' => $incompatibilities->pluck('id')->flatten()->toArray(),
        ]);
    }
}
