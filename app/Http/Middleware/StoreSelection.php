<?php

namespace PCForge\Http\Middleware;

use Closure;
use PCForge\Compatibility\Contracts\SelectionStorageServiceContract;
use PCForge\Compatibility\Helpers\Selection;

class StoreSelection
{
    /** @var SelectionStorageServiceContract */
    private $selectionStorageService;

    /** @var Selection $selection */
    private $selection;

    public function __construct(SelectionStorageServiceContract $selectionStorageService, Selection $selection)
    {
        $this->selectionStorageService = $selectionStorageService;
        $this->selection = $selection;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $this->selectionStorageService->store($this->selection);
    }
}
