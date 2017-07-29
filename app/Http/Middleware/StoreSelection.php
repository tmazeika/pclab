<?php

namespace PCForge\Http\Middleware;

use Closure;
use PCForge\Compatibility\Contracts\SelectionStorageServiceContract;

class StoreSelection
{
    /** @var SelectionStorageServiceContract $selectionStorageService */
    private $selectionStorageService;

    public function __construct(SelectionStorageServiceContract $selectionStorageService)
    {
        $this->selectionStorageService = $selectionStorageService;
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
        $this->selectionStorageService->store();
    }
}
