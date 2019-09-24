<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\DeviceRepository;
use Illuminate\Http\Request;

class DevicesController extends Controller
{
    private $repository;
    public function __construct()
    {
        $this->repository = new DeviceRepository;
    }

    public function index()
    {
        $devices = $this->repository->getAllDevices();
        return response()->json($devices['response'], $devices['status']);
    }

    public function validateLicense($license)
    {
        $device = $this->repository->getUsersDeviceByLicense($license);
        return response()->json($device['response'], $device['status']);
    }

    public function associateDevice(Request $request, $license)
    {
        $device = $this->repository->associateDevice($request, $license);
        return response()->json($device['response'], $device['status']);
    }
}
