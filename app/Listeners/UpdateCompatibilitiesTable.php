<?php

namespace PCForge\Listeners;

class UpdateCompatibilitiesTable
{
    /**
     * Handle the event.
     */
    public function handle(): void
    {
        cache()->tags(['static.compatibilities', 'static.incompatibilities'])->flush();
    }
}
