<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\TransmitterRepository;
use App\Transmitter;
use Illuminate\Http\Request;

class TransmittersController extends Controller
{
    private $repository;
    public function __construct()
    {
        $this->repository = new TransmitterRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $transmitters = Transmitter::belongsToSite($request->site)
            ->belongsToTeam()
            ->get();
        return response()->json($transmitters, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $ifu = $this->repository->getUsersTransmitterById($id);
        return response()->json($ifu, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param mixed $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $transmitter_update = $this->repository->updateTransmitter($request, $id);
        return response()->json($transmitter_update['response'], $transmitter_update['status']);
    }

    public function disassociateTransmitter($id)
    {
        $transmitter_disassociate = $this->repository->disassociateTransmitter($id);
        return response()->json($transmitter_disassociate['response'], $transmitter_disassociate['status']);
    }
}
