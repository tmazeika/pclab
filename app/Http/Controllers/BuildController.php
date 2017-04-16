<?php

namespace PCForge\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentCompatibilityServiceContract;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Contracts\ComponentSelectionRepositoryContract;
use PCForge\Http\Requests\SelectComponent;
use PCForge\Models\Component;

class BuildController extends Controller
{
    public function index()
    {
        //$components = $componentRepo->all()
        //    ->reject(function (Component $component) use ($compatibilityService) {
        //        return $compatibilityService->isUnavailable($component->id);
        //    })
        //    ->each(function (Component $component) use ($componentSelectionRepo) {
        //        $component->disabled = in_array($component->id, session('incompatibilities', []));
        //        $component->selected = $componentSelectionRepo->isSelected($component->id);
        //    })
        //    ->groupBy('component_type_id')
        //    ->sortBy(function ($value, int $key) {
        //        return $key;
        //    })
        //    ->map(function (Collection $collection) {
        //        return $collection->map(function (Component $component) {
        //            return $component->child();
        //        });
        //    });
        //

        return view('build.index');
    }

    public function select(SelectComponent $request)
    {
        return response()->json([
            'disable' => [/* TODO */],
        ]);
    }
}
