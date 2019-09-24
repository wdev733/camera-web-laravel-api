<?php

namespace App\Repository;

use App\View;

class ViewRepository
{
    public function getUsersViewById($id)
    {
        $user = auth('api')->user();
        $view = View::select('id', 'name', 'layout_data', 'created_at', 'updated_at', \DB::raw('(CASE WHEN user_id = '.$user->id.' THEN "user" ELSE "team" END) AS type'))
            ->belongsToTeam()
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id);
                $q->orWhere('user_id', null);
            })
            ->where('id', $id)
            ->first();
        return $view;
    }

    public function createView($request)
    {
        $request->validate([
            'name' => 'required|string',
            'layout_data' => 'required|string',
            'type' => 'required|string',
        ]);
        if (! auth('api')->user()->isAdminOfCurrentTeam() && $request->type == 'team') {
            return ['response'=>['message'=>'You are not allowed to update devices in this team.'], 'status'=>403];
        }
        $view = new View;
        $view->name = $request->name;
        $view->layout_data = $request->layout_data;
        $view->team_id = auth('api')->user()->current_team_id;
        if ($request->type == 'user') {
            $view->user_id = auth('api')->id();
        }
        $view->save();

        return $view;
    }

    public function updateView($request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'layout_data' => 'required|string',
            'type' => 'required|string',
        ]);
        $view = $this->getUsersViewById($id);
        if ($view) {
            if (! auth('api')->user()->isAdminOfCurrentTeam() && ($request->type == 'team' || is_null($view->user_id))) {
                return ['response'=>['message'=>'You are not allowed to update devices in this team.'], 'status'=>403];
            }
            $view->name = $request->name;
            $view->layout_data = $request->layout_data;
            $view->team_id = auth('api')->user()->current_team_id;
            if ($request->type == 'user') {
                $view->user_id = auth('api')->id();
            }
            if ($request->type == 'team') {
                $view->user_id = null;
            }
            $view->save();
            return ['response'=>['message'=>'View successfully updated.'], 'status'=>200];
        }
        return ['response'=>['message'=>'This view does not belong to one of your teams.'], 'status'=>403];
    }

    public function deleteView($id)
    {
        $view = $this->getUsersViewById($id);
        if ($view) {
            $view->delete();
            return ['response'=>['message'=>'View successfully deleted.'], 'status'=>200];
        }
        return ['response'=>['message'=>'This view does not belong to one of your teams.'], 'status'=>403];
    }
}
