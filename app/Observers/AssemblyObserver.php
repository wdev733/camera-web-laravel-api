<?php

namespace App\Observers;

use App\Assembly;

class AssemblyObserver
{
    /**
     * Handle the assembly "creating" event.
     *
     * @param  \App\Assembly  $assembly
     * @return void
     */
    public function creating(Assembly $assembly)
    {
        $unique = false;
        while (! $unique) {
            $license_key = licenseKeyGenerator(16);
            if (Assembly::where('license_key', $license_key)->count() == 0) {
                $unique = true;
            }
        }
        $assembly->license_key = $license_key;
    }

    /**
     * Handle the assembly "created" event.
     *
     * @param  \App\Assembly  $assembly
     * @return void
     */
    public function created(Assembly $assembly)
    {
        //
    }

    /**
     * Handle the assembly "updated" event.
     *
     * @param  \App\Assembly  $assembly
     * @return void
     */
    public function updated(Assembly $assembly)
    {
        //
    }

    /**
     * Handle the assembly "deleted" event.
     *
     * @param  \App\Assembly  $assembly
     * @return void
     */
    public function deleted(Assembly $assembly)
    {
        //
    }

    /**
     * Handle the assembly "restored" event.
     *
     * @param  \App\Assembly  $assembly
     * @return void
     */
    public function restored(Assembly $assembly)
    {
        //
    }

    /**
     * Handle the assembly "force deleted" event.
     *
     * @param  \App\Assembly  $assembly
     * @return void
     */
    public function forceDeleted(Assembly $assembly)
    {
        //
    }
}
