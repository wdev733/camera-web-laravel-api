<?php

namespace App\Http\Controllers;

use App\Ifu;
use Illuminate\Http\Request;

class IfuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    }

    public function regenerateKeys(Request $request)
    {
        $ifu = Ifu::find($request->id);
        if ($request->type == 'api_key') {
            $unique_api_key = false;
            while (! $unique_api_key) {
                $api_key = keyGenerator(16);
                if (Ifu::where('api_key', $api_key)->count() == 0) {
                    $unique_api_key = true;
                }
            }
            $ifu->api_key = $api_key;
            $ifu->save();
            return $api_key;
        } elseif ($request->type == 'vpn_username') {
            $unique_vpn_username = false;
            while (! $unique_vpn_username) {
                $vpn_username = keyGenerator(16);
                if (Ifu::where('vpn_username', $vpn_username)->count() == 0) {
                    $unique_vpn_username = true;
                }
            }
            $ifu->vpn_username = $vpn_username;
            $ifu->save();
            return $vpn_username;
        } elseif ($request->type == 'secret_key') {
            $unique_secret_key = false;
            while (! $unique_secret_key) {
                $secret_key = keyGenerator(16);
                if (Ifu::where('secret_key', $secret_key)->count() == 0) {
                    $unique_secret_key = true;
                }
            }
            $ifu->secret_key = $secret_key;
            $ifu->save();
            return $secret_key;
        }
    }
}
