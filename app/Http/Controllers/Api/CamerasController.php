<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CameraResource;
use App\Repository\CameraRepository;
use App\Camera;
use Illuminate\Http\Request;

class CamerasController extends Controller
{
    private $repository;
    public function __construct()
    {
        $this->repository = new CameraRepository;
    }

    /**
     * Return all the users cameras.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'site' => 'integer',
        ]);
        if ($request->site) {
            $cameras = Camera::belongsToSite($request->site)
                ->belongsToTeam()
                ->get();
        } else {
            $cameras = Camera::belongsToTeam()
                ->get();
        }
        foreach ($cameras as $camera) {
            unset($camera->camera_username);
            unset($camera->camera_password);
            $camera->permissions = $this->repository->getAuthUsersCameraPermissions($camera->id);
            if (! $camera->permissions['can_view']) {
                unset($camera->pin);
            }
        }
        return response()->json($cameras, 200);
    }

    /**
     * Return a specific camera
     *
     * @param  int $id
     * @return  \Symfony\Component\HttpFoundation\Response
     */
    public function show($id)
    {
        $camera = $this->repository->getUsersCameraById($id);
        $camera->permissions = $this->repository->getAuthUsersCameraPermissions($id);

        return response()->json(new CameraResource($camera));
    }

    /**
     * Update a camera
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return  \Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, $id)
    {
        $camera_update = $this->repository->updateCamera($request, $id);
        return response()->json($camera_update['response'], $camera_update['status']);
    }

    /**
     * Dissasociate a camera from a team
     *
     * @param  int $id
     * @return  \Symfony\Component\HttpFoundation\Response
     */
    public function disassociateCamera($id)
    {
        $camera_disassociate = $this->repository->disassociateCamera($id);
        return response()->json($camera_disassociate['response'], $camera_disassociate['status']);
    }

    /*
     * Get a camera's permissions
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return  \Symfony\Component\HttpFoundation\Response
     */
    public function getCameraPermissions(Request $request, $id)
    {
        $camera_permissions = $this->repository->getCameraPermissions($id, $request);
        return response()->json($camera_permissions, 200);
    }

    /*
     * Update a camera's permissions
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return  \Symfony\Component\HttpFoundation\Response
     */
    public function updateCameraPermissions(Request $request, $id)
    {
        $camera_permissions = $this->repository->updateCameraPermissions($id, $request);
        return response()->json($camera_permissions['response'], $camera_permissions['status']);
    }
}
