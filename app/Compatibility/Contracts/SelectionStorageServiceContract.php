<?php

namespace PCLab\Compatibility\Contracts;

interface SelectionStorageServiceContract
{
    /**
     * Stores the (likely mutated) singleton Selection in the session.
     *
     * @see SelectionContract
     */
    public function store(): void;

    /**
     * Retrieves the singleton Selection from the session. Does not perform any caching.
     *
     * @return SelectionContract
     */
    public function retrieve(): SelectionContract;
}
