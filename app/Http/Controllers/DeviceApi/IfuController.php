<?php


namespace App\Http\Controllers\DeviceApi;

use App\Ifu;
use Illuminate\Http\Request;

/**
 * Class IfuController
 * @group Device management API
 */
class IfuController
{
    /**
     * Get an IFus API key via it's mac address
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  \Symfony\Component\HttpFoundation\Response
     * @bodyParam mac_address string required The mac address of the IFU.
     * @response {
     *  "api_key": "XXXXXXXX"
     * }
     * @response 403 {
     *  "message": "IFU with this mac address not found."
     * }
     */
    public function register(Request $request)
    {
        $macAddress = $request->get('mac_address');
        $macAddress = str_replace(':', '', $macAddress);
        $ifu = Ifu::where('mac', $macAddress)->first();
        if ($ifu) {
            return response()->json(['api_key'=>$ifu->api_key], 200);
        }
        return response()->json(['message'=>'IFU with this mac address not found.'], 403);
    }

    /**
     * Update an IFUs VPN IP address
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  \Symfony\Component\HttpFoundation\Response
     * @bodyParam vpn_ip string required The VPN IP address of the IFU.
     * @response {
     *  "status": "success", "data": { "vpn_ip": "xxx" }
     * }
     * @response 403 {
     *  "message": "IFU with this API Key not found."
     * }
     */
    public function updateVpnIp(Request $request)
    {
        $request->validate([
            'vpn_ip' => 'ip|required',
        ]);

        $api_key = $request->header('apiKey');
        $ifu = Ifu::where('api_key', $api_key)->first();

        if ($ifu) {
            $ifu->vpn_ip = $request->vpn_ip;
            $ifu->save();
            return response()->json(['status'=>'success', 'data'=>['vpn_ip' => $ifu->vpn_ip]], 200);
        }
        return response()->json(['message'=>'IFU with this API Key not found'], 404);
    }

    public function configuration(Request $request)
    {
        $api_key = $request->header('apiKey');
        $ifu = Ifu::where('api_key', $api_key)->first();
        $config = [];
        if (! $ifu) {
            return response()->json(['message'=>'IFU with this API key not found.'], 403);
        }
        $config['settings']['vpn_username'] = $ifu->vpn_username;
        $config['settings']['vpn_password'] = $ifu->vpn_password;
        $config['settings']['vpn_server'] = $ifu->vpn_server;
        $config['settings']['secret_key'] = $ifu->secret_key;
        $config['settings']['id'] = $ifu->id;
        $config['cameras'] = [];
        $config['transmitters'] = [];
        if ($ifu->cameras) {
            foreach ($ifu->cameras as $camera) {
                $config['cameras'][$camera->id]['mac'] = $camera->mac;
                $config['cameras'][$camera->id]['id'] = $camera->id;
                $config['cameras'][$camera->id]['username'] = $camera->camera_username;
                $config['cameras'][$camera->id]['password'] = $camera->camera_password;
                $config['cameras'][$camera->id]['pin'] = $camera->pin;
                $config['cameras'][$camera->id]['camera_type'] = null;
                $config['cameras'][$camera->id]['camera_profile'] = null;
                $config['cameras'][$camera->id]['stream_url_1'] = $camera->cameraType->cameraProfile->stream_1_url;
                $config['cameras'][$camera->id]['stream_url_2'] = $camera->cameraType->cameraProfile->stream_2_url;
                $config['cameras'][$camera->id]['stream_url_3'] = $camera->cameraType->cameraProfile->stream_3_url;
                $config['cameras'][$camera->id]['ptz_enabled'] = $camera->cameraType->cameraProfile->ptz_enabled;
                $config['cameras'][$camera->id]['camera_type'] = $camera->cameraType->label;
            }
        }
        if ($ifu->transmitters) {
            foreach ($ifu->transmitters as $transmitter) {
                $config['transmitters'][$transmitter->id]['mac'] = $transmitter->mac;
                $config['transmitters'][$transmitter->id]['id'] = $transmitter->id;
                $config['transmitters'][$transmitter->id]['transmitter_type'] = null;
                $config['transmitters'][$transmitter->id]['ip'] = $transmitter->local_ip;
                if ($transmitter->transmitterType) {
                    $config['transmitters'][$transmitter->id]['transmitter_type'] = $transmitter->transmitterType->label;
                }
            }
        }
        return response()->json(['configuration'=>$config], 200);
    }
}
