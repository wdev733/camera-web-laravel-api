<?php

namespace App\Observers;

use App\Camera;

class CameraObserver
{
    /**
     * Handle the camera "creating" event.
     */
    public function creating(Camera $camera)
    {
        $unique = false;
        while (! $unique) {
            $license_key = licenseKeyGenerator(16);
            if (Camera::where('license_key', $license_key)->count() == 0) {
                $unique = true;
            }
        }
        $unique_pin = false;
        while (! $unique_pin) {
            $pin = keyGenerator(16);
            if (Camera::where('pin', $pin)->count() == 0) {
                $unique_pin = true;
            }
        }
        $camera->license_key = $license_key;
        $camera->pin = $pin;
    }
    public function updating(Camera $camera)
    {
    }
    /**
     * Handle the camera "created" event.
     */
    public function created(Camera $camera)
    {
        //
    }

    /**
     * Handle the camera "updated" event.
     */
    public function updated(Camera $camera)
    {
        //
    }

    /**
     * Handle the camera "deleted" event.
     */
    public function deleted(Camera $camera)
    {
        //
    }

    /**
     * Handle the camera "restored" event.
     */
    public function restored(Camera $camera)
    {
        //
    }

    /**
     * Handle the camera "force deleted" event.
     */
    public function forceDeleted(Camera $camera)
    {
        //
    }
}
