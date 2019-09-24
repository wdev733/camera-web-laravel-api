<?php

namespace App\Observers;

use App\Ifu;

class IfuObserver
{
    /**
     * Handle the ifu "creating" event.
     *
     * @param  \App\Ifu  $ifu
     * @return void
     */
    public function creating(Ifu $ifu)
    {
        $unique_license_key = false;
        while (! $unique_license_key) {
            $license_key = licenseKeyGenerator(16);
            if (Ifu::where('license_key', $license_key)->count() == 0) {
                $unique_license_key = true;
            }
        }
        $unique_api_key = false;
        while (! $unique_api_key) {
            $api_key = keyGenerator(16);
            if (Ifu::where('api_key', $api_key)->count() == 0) {
                $unique_api_key = true;
            }
        }
        $unique_vpn_password = false;
        while (! $unique_vpn_password) {
            $vpn_password = keyGenerator(16);
            if (Ifu::where('vpn_password', $vpn_password)->count() == 0) {
                $unique_vpn_password = true;
            }
        }
        $unique_secret_key = false;
        while (! $unique_secret_key) {
            $secret_key = keyGenerator(16);
            if (Ifu::where('secret_key', $secret_key)->count() == 0) {
                $unique_secret_key = true;
            }
        }
        $ifu->license_key = $license_key;
        $ifu->api_key = $api_key;
        $ifu->vpn_password = $vpn_password;
        $ifu->secret_key = $secret_key;
    }

    /**
     * Handle the ifu "created" event.
     *
     * @param  \App\Ifu  $ifu
     * @return void
     */
    public function created(Ifu $ifu)
    {
        //
    }

    /**
     * Handle the ifu "updated" event.
     *
     * @param  \App\Ifu  $ifu
     * @return void
     */
    public function updated(Ifu $ifu)
    {
        //
    }

    /**
     * Handle the ifu "deleted" event.
     *
     * @param  \App\Ifu  $ifu
     * @return void
     */
    public function deleted(Ifu $ifu)
    {
        //
    }

    /**
     * Handle the ifu "restored" event.
     *
     * @param  \App\Ifu  $ifu
     * @return void
     */
    public function restored(Ifu $ifu)
    {
        //
    }

    /**
     * Handle the ifu "force deleted" event.
     *
     * @param  \App\Ifu  $ifu
     * @return void
     */
    public function forceDeleted(Ifu $ifu)
    {
        //
    }
}
