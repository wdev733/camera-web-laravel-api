<?php

namespace App\Repository;

use App\Camera;
use App\CameraPermission;
use App\Site;
use App\UserCameraPermission;

class CameraRepository
{
    public function getUsersCameraById($id)
    {
        $camera = Camera::belongsToTeam()
            ->where('id', $id)
            ->with('cameraType')
            ->first();

        if ($camera instanceof Camera) {
            $streamOne = $camera->cameraType->cameraProfile->stream_1_url;
            $streamTwo = $camera->cameraType->cameraProfile->stream_2_url;
            $streamThree = $camera->cameraType->cameraProfile->stream_3_url;

            $streams = [];
            if ($streamOne) {
                $streams[1]['janus_id'] = $camera->id . '1';
                $streams[1]['quality'] = 1;
            }
            if ($streamTwo) {
                $streams[2]['janus_id'] = $camera->id . '2';
                $streams[2]['quality'] = 2;
            }
            if ($streamThree) {
                $streams[3]['janus_id'] = $camera->id . '3';
                $streams[3]['quality'] = 3;
            }

            $camera->janus_streams = $streams;
        }

        return $camera;
    }

    public function updateCamera($request, $camera_id)
    {
        if (! auth('api')->user()->isAdminOfCurrentTeam()) {
            return ['response'=>['message'=>'You are not allowed to update devices in this team.'], 'status'=>403];
        }
        $camera = $this->getUsersCameraById($camera_id);
        if (! $camera) {
            return ['response'=>['message'=>'This camera does not belong to one of your teams.'], 'status'=>403];
        }
        $request->validate([
            'site_id' => 'required|integer',
            'name' => 'string|nullable',
            'location' => 'string|nullable',
            'description' => 'string|nullable',
        ]);
        $camera = Camera::findOrFail($camera_id);
        $site = Site::findOrFail($request->site_id);
        if ($site->team_id != $camera->team_id) {
            return ['response'=>['message'=>'This site belongs to another team.'], 'status'=>403];
        }
        $camera->site_id = $request->site_id;
        $camera->name = $request->name;
        $camera->location = $request->location;
        $camera->description = $request->description;
        $camera->save();
        return ['response'=>$camera, 'status'=>200];
    }

    public function disassociateCamera($id)
    {
        if (! auth('api')->user()->isAdminOfCurrentTeam()) {
            return ['response'=>['message'=>'You are not allowed to update devices in this team.'], 'status'=>403];
        }
        $camera = $this->getUsersCameraById($id);
        if ($camera) {
            $camera->site_id = null;
            $camera->team_id = null;
            $camera->ifu_id = null;
            $camera->save();
            return ['response'=>['message'=>'Camera successfully disassociated.'], 'status'=>200];
        }
        return ['response'=>['message'=>'This camera does not belong to one of your teams.'], 'status'=>403];
    }

    public function getCameraPermissions($id, $request)
    {
        $request->validate([
            'user' => 'required|integer',
        ]);
        return $this->getPermissions($id, $request->user);
    }

    public function getAuthUsersCameraPermissions($id)
    {
        return $this->getPermissions($id);
    }

    private function getPermissions($id, $userId = false)
    {
        if (! $userId) {
            $userId = auth('api')->id();
        }
        $defaultCameraPermissions = CameraPermission::all();
        $defaultCameraPermissions->map(function ($defaultCameraPermission) use ($userId, $id) {
            $negativePermission = UserCameraPermission::where('user_id', $userId)
                ->where('camera_id', $id)
                ->where('permission_id', $defaultCameraPermission->id)
                ->first();
            if ($negativePermission) { // check if user has a negative permissions.
                return $defaultCameraPermission->default_value = false; // change the default permission to be false
            }
        });
        $cameraPermissions = $defaultCameraPermissions->pluck('default_value', 'name');
        return $cameraPermissions;
    }

    public function updateCameraPermissions($id, $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'can_view' => 'required|boolean',
            'can_view_recordings' => 'required|boolean',
            'can_ptz' => 'required|boolean',
            'can_preset' => 'required|boolean',
            'can_edit_preset' => 'required|boolean',
        ]);
        $permissions = CameraPermission::whereIn('name', array_keys($request->all()))->get();
        $permissions_insert = [];
        foreach ($permissions as $permission) {
            if (isset($request[$permission->name]) && ! $request[$permission->name]) {
                // if the permission is set to 'false' in the response, we need to add it to the database (all permisions are negative)
                array_push(
                    $permissions_insert,
                    [
                        'user_id' => $request->user_id,
                        'camera_id' => $id,
                        'permission_id' => $permission->id,
                    ]
                );
            }
        }
        UserCameraPermission::where('user_id', $request->user_id)
            ->where('camera_id', $id)
            ->delete();
        UserCameraPermission::insert($permissions_insert);
        return ['response'=>['message'=>'User permissions successfully updated.'], 'status'=>200];
    }
}
