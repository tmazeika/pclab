<?php

namespace PCForge\Http\Controllers;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentIncompatibilityServiceContract;
use PCForge\Contracts\ComponentSelectionServiceContract;
use PCForge\Http\Requests\SelectComponent;
use PCForge\Models\Component;

class BuildController extends Controller
{
    /** @var ComponentIncompatibilityServiceContract $componentIncompatibilityService */
    private $componentIncompatibilityService;

    /** @var ComponentSelectionServiceContract $componentSelectionService */
    private $componentSelectionService;

    public function __construct(ComponentIncompatibilityServiceContract $componentIncompatibilityService,
                                ComponentSelectionServiceContract $componentSelectionService)
    {
        $this->componentIncompatibilityService = $componentIncompatibilityService;
        $this->componentSelectionService = $componentSelectionService;
    }

    public function index()
    {
        $components = Component::whereNotIn('id', $this->componentIncompatibilityService->getIncompatibilities([])->pluck('id'))
            ->get()
            ->groupBy('component_type_id')
            ->sortBy(function ($value, int $key) {
                return $key;
            })
            ->map(function (Collection $components) {
                return $components->map(function (Component $component) {
                    return $component->child;
                });
            });

        return view('build.index', compact('components'));
    }

    public function select(SelectComponent $request)
    {
        $this->componentSelectionService->select($request->input('id'), $request->input('count'));

        $incompatibilities = $this->componentIncompatibilityService
            ->getIncompatibilities($this->componentSelectionService->selection());

        return response()->json([
            'disable' => $incompatibilities->pluck('id')->toArray(),
        ]);
    }
}
