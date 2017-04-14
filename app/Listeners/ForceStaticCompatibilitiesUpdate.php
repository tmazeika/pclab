<?php

namespace PCForge\Listeners;

class ForceStaticCompatibilitiesUpdate
{
    /**
     * Handle the event.
     */
    public function handle(): void
    {
        cache()->tags('components')->flush();
    }
}
