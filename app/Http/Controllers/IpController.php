<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IpController extends Controller
{
    /**
     * Return the requestors public IP address
     */

    public function index(Request $request)
    {
        $ip = $request->getClientIp();
        return $ip;
    }
}
