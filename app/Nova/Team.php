<?php

namespace App\Nova;

use App\TeamUser;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class Team extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Team';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name',
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Authentication';

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:teams,name')
                ->updateRules('unique:teams,name,{{resourceId}}'),

            Text::make('Slug')
                ->sortable()
                ->rules('required', 'max:255')->hideWhenCreating()->hideWhenUpdating(),

            Select::make('Owner')->options(
                \App\User::select(DB::raw("CONCAT(first_name,' ',last_name) AS name"), 'id')->pluck('name', 'id')
            )
                ->hideFromDetail()
                ->hideFromIndex()
                ->rules('required')
                ->withMeta(['value'=>(\App\Team::find($this->id) && \App\Team::find($this->id)->owner) ? \App\Team::find($this->id)->owner->id : '']),

            BelongsToMany::make('Users', 'users'),

            HasMany::make('Cameras', 'cameras'),

            HasMany::make('IFUs', 'ifus'),

            HasMany::make('Sites', 'sites'),

            HasMany::make('Transmitters', 'transmitters'),

            HasMany::make('Views', 'views'),


        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        $team_user = new TeamUser;
        $team_user->team_id = $resource->getKey();
        $team_user->user_id = $request->owner;
        $team_user->team_role_id = \Config::get('teamrole.default_owner_role');
        $team_user->save();
        return parent::redirectAfterCreate($request, $resource);
    }

    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        TeamUser::where('team_role_id', \Config::get('teamrole.default_owner_role'))->where('team_id', $resource->getKey())->update(['team_role_id'=>\Config::get('teamrole.default_team_role')]);
        $user = \App\User::find($request->owner);
        $user->attachTeam($resource->getKey());
        $user->updateTeamRole(\Config::get('teamrole.default_owner_role'), $resource->getKey());
    }
}
