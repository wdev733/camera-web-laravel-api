<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\IfuRepository;
use App\Ifu;
use Illuminate\Http\Request;

class IfusController extends Controller
{
    private $repository;
    public function __construct()
    {
        $this->repository = new IfuRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'site' => 'required|integer',
        ]);
        $ifus = Ifu::belongsToSite($request->site)
            ->belongsToTeam()
            ->get();
        return response()->json($ifus, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $ifu = $this->repository->getUsersIfuById($id);
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
        $ifu_update = $this->repository->updateIfu($request, $id);
        return response()->json($ifu_update['response'], $ifu_update['status']);
    }

    public function disassociateIfu($id)
    {
        $ifu_disassociate = $this->repository->disassociateIfu($id);
        return response()->json($ifu_disassociate['response'], $ifu_disassociate['status']);
    }
}
