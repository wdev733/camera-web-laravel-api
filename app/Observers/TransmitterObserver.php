<?php

namespace App\Observers;

use App\Transmitter;

class TransmitterObserver
{
    /**
     * Handle the transmitter "creating" event.
     *
     * @param  \App\Transmitter  $transmitter
     * @return void
     */
    public function creating(Transmitter $transmitter)
    {
        $unique = false;
        $unique_ssid = false;
        while (! $unique) {
            $license_key = licenseKeyGenerator(16);
            if (Transmitter::where('license_key', $license_key)->count() == 0) {
                $unique = true;
            }
        }
        $transmitter->license_key = $license_key;
        if ($transmitter->mode == 'AP' || is_null($transmitter->old_transmitter)) {
            if (is_null($transmitter->password)) {
                $transmitter->password = keyGenerator(16);
            }
            if (is_null($transmitter->ssid)) {
                while (! $unique_ssid) {
                    $ssid = 'RUGNET0';
                    $ssid .= idGenerator(5);
                    if (Transmitter::where('ssid', $ssid)->count() == 0) {
                        $unique_ssid = true;
                    }
                }
                $transmitter->ssid = $ssid;
            }
        } else {
            $old_transmitter = Transmitter::find($transmitter->old_transmitter);
            $transmitter->ssid = $old_transmitter->ssid;
            $transmitter->password = $old_transmitter->password;
        }
        unset($transmitter->old_transmitter);
    }

    /**
     * Handle the transmitter "created" event.
     *
     * @param  \App\Transmitter  $transmitter
     * @return void
     */
    public function created(Transmitter $transmitter)
    {
        //
    }

    /**
     * Handle the transmitter "updated" event.
     *
     * @param  \App\Transmitter  $transmitter
     * @return void
     */
    public function updated(Transmitter $transmitter)
    {
        //
    }

    /**
     * Handle the transmitter "deleted" event.
     *
     * @param  \App\Transmitter  $transmitter
     * @return void
     */
    public function deleted(Transmitter $transmitter)
    {
        //
    }

    /**
     * Handle the transmitter "restored" event.
     *
     * @param  \App\Transmitter  $transmitter
     * @return void
     */
    public function restored(Transmitter $transmitter)
    {
        //
    }

    /**
     * Handle the transmitter "force deleted" event.
     *
     * @param  \App\Transmitter  $transmitter
     * @return void
     */
    public function forceDeleted(Transmitter $transmitter)
    {
        //
    }
}
