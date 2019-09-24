<?php

namespace App\Nova;

use Epartment\NovaDependencyContainer\HasDependencies;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Orlyapps\NovaBelongsToDepend\NovaBelongsToDepend;

class Assembly extends Resource
{
    use HasDependencies;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Assembly';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'license_key',
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Devices';

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

            Text::make('License key', function () {
                return addingHyphensToKeys($this->license_key);
            })
                ->sortable()
                ->rules('max:255')
                ->hideWhenUpdating()
                ->hideWhenCreating(),

            Select::make('Team', 'team_id')->options(
                \App\Team::all()->pluck('name', 'id')
            )->withMeta(['value'=>(isset($this->team_id)) ? $this->team_id : ''])
                ->nullable()
                ->hideFromIndex()
                ->hideFromDetail()
                ->hideWhenCreating(),
            NovaBelongsToDepend::make('Team')
                ->options(\App\Team::all())
                ->hideWhenUpdating()
                ->hideWhenCreating(),
            NovaDependencyContainer::make([
                NovaBelongsToDepend::make('Site')
                    ->options(\App\Site::all())
                    ->dependsOn('Team')->nullable(),
            ])->dependsOnNotEmpty('team_id')
                ->hideWhenCreating(),
            NovaBelongsToDepend::make('AssemblyType')
                ->options(\App\Team::all())
                ->singularLabel('Assembly Type'),
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
}
