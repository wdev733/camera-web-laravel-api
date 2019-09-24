<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\ViewRepository;
use App\View;
use Illuminate\Http\Request;

class ViewsController extends Controller
{
    private $repository;
    public function __construct()
    {
        $this->repository = new ViewRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = auth('api')->user();
        $views = View::select('id', 'name', 'layout_data', \DB::raw('(CASE WHEN user_id = '.$user->id.' THEN "user" ELSE "team" END) AS type'))
            ->belongsToTeam()
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id);
                $q->orWhere('user_id', null);
            })
            ->get();
        return response()->json($views, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $view = $this->repository->getUsersViewById($id);
        return response()->json($view, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param mixed $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $view_update = $this->repository->updateView($request, $id);
        return response()->json($view_update['response'], $view_update['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $view_create = $this->repository->createView($request);
        return response()->json(['id'=>$view_create->id, 'message'=>'View successfully created.'], 201);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $id
     * @return Response
     */
    public function destroy($id)
    {
        $view_delete = $this->repository->deleteView($id);
        return response()->json($view_delete['response'], $view_delete['status']);
    }
}
