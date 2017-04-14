<?php

namespace PCForge\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PCForge\Contracts\CompatibilityServiceContract;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Contracts\ComponentSelectionRepositoryContract;
use PCForge\Models\Component;

class BuildController extends Controller
{
    public function index()
    {
        return view('build.index');
    }

    public function showCustom(ComponentRepositoryContract $componentRepo,
                               CompatibilityServiceContract $compatibilityService,
                               ComponentSelectionRepositoryContract $componentSelectionRepo)
    {
        $components = $componentRepo->all()
            ->reject(function (Component $component) use ($compatibilityService) {
                return $compatibilityService->isUnavailable($component->id);
            })
            ->each(function (Component $component) use ($componentSelectionRepo) {
                $component->disabled = in_array($component->id, session('incompatibilities', []));
                $component->selected = $componentSelectionRepo->isSelected($component->id);
            })
            ->groupBy('component_type_id')
            ->sortBy(function ($value, int $key) {
                return $key;
            })
            ->map(function (Collection $collection) {
                return $collection->map(function (Component $component) {
                    return $component->child();
                });
            });

        return view('build.custom', compact('components'));
    }

    public function showPreset()
    {
        return view('build.preset');
    }

    public function customSelect(Request $request, CompatibilityServiceContract $compatibilityService)
    {
        $this->validate($request, [
            'id'    => 'required|exists:components,id',
            'count' => 'required|integer|min:0',
        ]);

        $id = intval($request->input('id'));
        $count = intval($request->input('count'));

        return response()->json([
            'disable' => $compatibilityService->select($id, $count)->toArray(),
        ]);
    }
}
