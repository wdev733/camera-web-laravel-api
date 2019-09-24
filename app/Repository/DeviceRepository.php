<?php

namespace App\Repository;

use App\Assembly;
use App\Camera;
use App\Ifu;
use App\Transmitter;

class DeviceRepository
{
    public function getAllDevices()
    {
        $ifus = Ifu::belongsToTeam()->with('ifuType')->get();
        $cameras = Camera::belongsToTeam()->with('cameraType')->get();
        $transmitters = Transmitter::belongsToTeam()->with('transmitterType')->get();
        return ['response'=>['ifus'=>$ifus, 'transmitters'=>$transmitters, 'cameras'=>$cameras], 'status'=>200];
    }

    public function getUsersDeviceByLicense($license)
    {
        $device = Assembly::where('license_key', $license)->first();
        if ($device) {
            if ($device->team_id) {
                return ['response'=>['message'=>'This assembly has already been registered.'], 'status'=>403];
            }
            return ['response'=>['type'=>'assembly', 'device'=>$device], 'status'=>200];
        }

        $device = Camera::where('license_key', $license)->first();
        if ($device) {
            if ($device->team_id) {
                return ['response'=>['message'=>'This camera has already been registered.'], 'status'=>403];
            }
            return ['response'=>['type'=>'camera', 'device'=>$device], 'status'=>200];
        }

        $device = Ifu::where('license_key', $license)->first();
        if ($device) {
            if ($device->team_id) {
                return ['response'=>['message'=>'This IFU has already been registered.'], 'status'=>403];
            }
            return ['response'=>['type'=>'ifu', 'device'=>$device], 'status'=>200];
        }

        $device = Transmitter::where('license_key', $license)->first();
        if ($device) {
            if ($device->team_id) {
                return ['response'=>['message'=>'This transmitter has already been registered.'], 'status'=>403];
            }
            return ['response'=>['type'=>'transmitter', 'device'=>$device], 'status'=>200];
        }

        return ['response'=>['message'=>'License key was not recognised.'], 'status'=>403];
    }

    public function associateDevice($request, $license)
    {
        if (! auth('api')->user()->isAdminOfCurrentTeam()) {
            return ['response'=>['message'=>'You are not allowed to update devices in this team.'], 'status'=>403];
        }
        $request->validate([
            'site_id' => 'required|integer',
        ]);

        $device = Assembly::where('license_key', $license)
            ->first();
        if ($device) {
            return $this->updateDeviceTeamAndSite($device, $request->site_id);
        }
        $device = Camera::where('license_key', $license)
            ->first();
        if ($device) {
            return $this->updateDeviceTeamAndSite($device, $request->site_id, true);
        }
        $device = Ifu::where('license_key', $license)
            ->first();
        if ($device) {
            return $this->updateDeviceTeamAndSite($device, $request->site_id);
        }
        $device = Transmitter::where('license_key', $license)
            ->first();
        if ($device) {
            return $this->updateDeviceTeamAndSite($device, $request->site_id, true);
        }
        return ['response'=>['message'=>'License key was not recognised.'], 'status'=>403];
    }

    private function updateDeviceTeamAndSite($device, $site_id, $check_ifu = false)
    {
        if ($device->team_id) {
            return ['response'=>['message'=>'This device has already been registered.'], 'status'=>403];
        }
        if ($check_ifu) {
            $ifu = Ifu::where('site_id', $site_id)->orderBy('id', 'desc')->first();
            if ($ifu) {
                $device->ifu_id = $ifu->id;
            }
        }
        $device->team_id = auth('api')->user()->current_team_id;
        $device->site_id = $site_id;
        $device->save();
        return ['response'=>['message'=>'Device successfully registered.'], 'status'=>200];
    }
}
