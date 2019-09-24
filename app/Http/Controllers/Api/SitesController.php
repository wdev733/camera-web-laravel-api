<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\SiteRepository;
use App\Site;
use Illuminate\Http\Request;

class SitesController extends Controller
{
    private $repository;
    public function __construct()
    {
        $this->repository = new SiteRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $sites = Site::belongsToTeam()
            ->get();
        return response()->json($sites, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $site_creation = $this->repository->createSite($request);
        return response()->json($site_creation, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $site = $this->repository->getUsersSiteById($id);
        return response()->json($site, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param mixed $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $site_update = $this->repository->updateSite($request, $id, auth('api')->id());
        return response()->json($site_update['response'], $site_update['status']);
    }
}
