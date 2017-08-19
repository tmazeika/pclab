<?php

namespace PCLab\Http\Controllers;

use Fhaculty\Graph\Graph;
use PCLab\Compatibility\Contracts\ComponentIncompatibilityServiceContract;
use PCLab\Compatibility\Contracts\ComponentRepositoryContract;
use PCLab\Compatibility\Contracts\IncompatibilityGraphContract;
use PCLab\Compatibility\Contracts\SelectionContract;
use PCLab\Http\Requests\SelectComponent;
use PCLab\Models\ComponentChild;

class BuildController extends Controller
{
    /** @var ComponentRepositoryContract $componentRepo */
    private $componentRepo;

    public function __construct(ComponentRepositoryContract $componentRepo)
    {
        $this->componentRepo = $componentRepo;
    }

    public function index(SelectionContract $selection)
    {
        $components = $this->componentRepo->get();

        $selection->setProperties($components);

        $components = $components->groupBy('parent.child_type');

        return view('build.index', compact('components'));
    }

    public function select(SelectComponent $request,
                           ComponentIncompatibilityServiceContract $componentIncompatibilityService,
                           SelectionContract $selection)
    {
        $component = $this->componentRepo->find($request->id);

        if ($selection->isDisabled($component)) {
            abort(400, 'Component is disabled');
        }

        $selection->select($component, $request->count);

        $incompatibilities = $componentIncompatibilityService->getIncompatibilities();

        $selection->disableOnly($incompatibilities->all());

        return response()->json([
            'disable' => $incompatibilities->pluck('parent.id'),
        ]);
    }
}
