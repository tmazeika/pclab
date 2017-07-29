<?php

namespace PCForge\Http\Controllers;

use Illuminate\Support\Collection;
use PCForge\Compatibility\Contracts\ComponentIncompatibilityServiceContract;
use PCForge\Compatibility\Contracts\SelectionContract;
use PCForge\Http\Requests\SelectComponent;
use PCForge\Models\Component;
use PCForge\Models\ComponentChild;

class BuildController extends Controller
{
    /** @var ComponentIncompatibilityServiceContract $componentIncompatibilityService */
    private $componentIncompatibilityService;

    /** @var SelectionContract $selection */
    private $selection;

    public function __construct(ComponentIncompatibilityServiceContract $componentIncompatibilityService,
                                SelectionContract $selection)
    {
        $this->componentIncompatibilityService = $componentIncompatibilityService;
        $this->selection = $selection;
    }

    public function index()
    {
        $incompatibilities = $this->componentIncompatibilityService->getIncompatibilities();

        // TODO: extract elsewhere
        $components = Component
            ::select('id', 'component_type_id', 'child_id', 'child_type')
            ->with('child')
            ->get()
            ->each(function (Component $component) use ($incompatibilities) {
                /** @var ComponentChild $child */
                //$child = $component->child;

                //@$child->disabled = $incompatibilities->contains($child);
            })
            ->groupBy('child_type')
            //->sortBy(function ($value, int $key) {
            //    return $key;
            //})
            ->map(function (Collection $components) {
                return $components->map(function (Component $component) {
                    return $component->child;
                });
            });

        return view('build.index', compact('components'));
    }

    public function select(SelectComponent $request)
    {
        // TODO: extract elsewhere
        $component = Component::find($request->get('id'))->child;

        $component->selectCount = $request->get('count');

        if ($component->selectCount > 0) {
            $this->selection->select($component);
        }
        else {
            $this->selection->deselect($component);
        }

        return response()->json([
            'disable' => $this->componentIncompatibilityService->getIncompatibilities()->map(function (ComponentChild $component) {
                return $component->parent->id;
            }),
        ]);
    }
}
