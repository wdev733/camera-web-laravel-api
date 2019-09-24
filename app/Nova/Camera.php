<?php

namespace App\Nova;

use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Epartment\NovaDependencyContainer\HasDependencies;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Orlyapps\NovaBelongsToDepend\NovaBelongsToDepend;
use Wemersonrv\InputMask\InputMask;

class Camera extends Resource
{
    use HasDependencies;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Camera';

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
        'id', 'name', 'mac', 'license_key',
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Cameras';

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
                ->rules('max:255')
                ->hideWhenCreating(),

            Textarea::make('Description')
                ->hideWhenCreating(),

            Text::make('Location')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->hideFromIndex(),

            InputMask::make('MAC')
                ->mask('XX:XX:XX:XX:XX:XX')
                ->raw()
                ->sortable()
                ->rules('required', 'string', 'unique:cameras,mac,{{resourceId}}', 'regex:/^[0-9A-Fa-f]*$/', 'size:12'),

            NovaBelongsToDepend::make('CameraType')
                ->options(\App\CameraType::all())
                ->rules('required')
                ->singularLabel('Camera Type'),
            // BelongsTo::make('CameraType', 'cameraType')->singularLabel('Camera Type'),
            NovaBelongsToDepend::make('Team')
                ->options(\App\Team::all())
                ->hideWhenCreating()
                ->nullable(),
            NovaBelongsToDepend::make('Site')
                ->optionsResolve(function (\App\Team $team) {
                    return $team->sites()->get(['id','name']);
                })
                ->dependsOn('Team')
                ->nullable()
                ->hideWhenCreating(),
            NovaBelongsToDepend::make('Ifu')
                ->optionsResolve(function (\App\Site $site) {
                    return $site->ifus()->get(['id','id']);
                })
                ->dependsOn('Site')
                ->nullable()
                ->hideWhenCreating(),
            NovaDependencyContainer::make([
                NovaBelongsToDepend::make('Assembly')
                    ->options(\App\Assembly::all())
                    ->nullable(),
            ])->dependsOn('team_id', '')
                ->hideWhenCreating(),
            NovaBelongsToDepend::make('RecordingProfile')
                ->options(\App\RecordingProfile::all())
                ->nullable()
                ->hideFromIndex()
                ->hideWhenCreating()
                ->singularLabel('Recording Profile'),

            Text::make('License key', function () {
                return addingHyphensToKeys($this->license_key);
            })
                ->sortable()
                ->rules('max:255')
                ->hideWhenUpdating()
                ->hideWhenCreating()
                ->hideFromIndex(),
            Text::make('Username', 'camera_username')
                ->sortable()
                ->rules('max:255')
                ->hideWhenCreating()
                ->hideFromIndex(),
            Text::make('Password', 'camera_password')
                ->sortable()
                ->rules('max:255')
                ->hideWhenCreating()
                ->hideFromIndex(),

            Text::make('Stream to record')
                ->sortable()
                ->rules('max:255')
                ->hideFromIndex()
                ->hideWhenCreating(),
            Text::make('Post record frames')
                ->sortable()
                ->rules('max:255')
                ->hideFromIndex()
                ->hideWhenCreating(),
            Text::make('Pre record frames')
                ->sortable()
                ->rules('max:255')
                ->hideFromIndex()
                ->hideWhenCreating(),
            Text::make('Motion sensitivity')
                ->sortable()
                ->rules('max:255')
                ->hideFromIndex()
                ->hideWhenCreating(),
            Text::make('PIN')
                ->hideWhenUpdating()
                ->hideWhenCreating()
                ->hideFromIndex(),
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
