<?php
    if (! function_exists('keyGenerator')) {
        function keyGenerator($length)
        {
            return \Illuminate\Support\Str::random($length);
        }
    }

    if (! function_exists('licenseKeyGenerator')) {
        function licenseKeyGenerator($length)
        {
            return strtoupper(\Illuminate\Support\Str::random($length));
        }
    }

    if (! function_exists('addingHyphensToKeys')) {
        function addingHyphensToKeys($string)
        {
            return implode('-', str_split($string, 4));
        }
    }

    if (! function_exists('idGenerator')) {
        function idGenerator($length)
        {
            $id = '';
            for ($i = 1; $i <= $length; $i++) {
                $id .= mt_rand(0, 9);
            }
            return $id;
        }
    }
