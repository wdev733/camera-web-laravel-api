<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RnlOfficeIpAddressFilter
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userIp = $request->ip();
        $officialIpRanges = \Config::get('onvp.office_ips');
        foreach ($officialIpRanges as $officialIpRange) {
            if (self::cidr_match($userIp, $officialIpRange)) {
                return $next($request);
            }

            return response()->json(['message' => 'IP address not allowed.'], 403);
        }
    }

    /**
     * Check the ip is involved in ip address ranges.
     * @param $ip
     * @param $range
     * @return bool
     */
    private static function cidr_match($ip, $range)
    {
        $bits = $subnet = null;
        if (strpos($range, '/') === false) {
            $subnet = $range; // in case that ip address only specified.
        } else {
            list($subnet, $bits) = explode('/', $range);
        }
        if ($bits === null) {
            $bits = 32;
        }
        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask;
        return ($ip & $mask) == $subnet;
    }
}
