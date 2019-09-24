<?php


namespace App\Http\Controllers\ServerApi;

use App\Ifu;
use Illuminate\Http\Request;

class VpnController
{
    public function index()
    {
        $ifus = Ifu::select('id', 'vpn_ip')->get();

        return response()->json($ifus, 200);
    }

    public function show(Request $request)
    {
        $ifu_id = $request->id;
        $vpn_ip = IFu::where('id', $ifu_id)->value('vpn_ip');

        return response()->json($vpn_ip, 200);
    }

    public function authenticate(Request $request)
    {
        $ifu_id = $request->ifu_id;
        $vpn_password = $request->vpn_password;

        $ifu = Ifu::where([
            ['id', '=', $ifu_id],
            ['vpn_password', '=', $vpn_password],
        ])->first();

        if ($ifu) {
            return response()->json(['status'=>'success', 'message' => 'Successfully validated provided credentials'], 200);
        }

        return response()->json(['status'=>'error', 'message'=>'Unable to authenticate IFU with provided credentials'], 403);
    }
}
