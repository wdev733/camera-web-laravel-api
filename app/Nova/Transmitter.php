<?php

namespace App\Nova;

use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Epartment\NovaDependencyContainer\HasDependencies;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Orlyapps\NovaBelongsToDepend\NovaBelongsToDepend;
use Wemersonrv\InputMask\InputMask;

class Transmitter extends Resource
{
    use HasDependencies;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Transmitter';

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
        'id', 'mac', 'ssid',
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
                ->hideWhenCreating()
                ->hideFromIndex(),
            InputMask::make('MAC')
                ->mask('XX:XX:XX:XX:XX:XX')
                ->raw()
                ->sortable()
                ->rules('required', 'string', 'unique:transmitters,mac,{{resourceId}}', 'regex:/^[0-9A-F]*$/', 'size:12'),
            Text::make('Local IP')
                ->sortable()
                ->rules('ipv4', 'nullable')
                ->hideWhenCreating()
                ->hideFromIndex(),
            Select::make('Mode')
                ->options([
                    'AP' => 'AP',
                    'STA' => 'STA',
                ])
                ->sortable()
                ->rules('required', 'max:255')
                ->hideWhenUpdating()
                ->withMeta(['value'=>(isset($this->mode)) ? $this->mode : '']),
            NovaDependencyContainer::make([
                Text::make('SSID')
                    ->sortable()
                    ->rules('max:255'),
                Text::make('Password')
                    ->sortable()
                    ->rules('max:255'),
            ])->dependsOn('mode', 'AP')
                ->hideWhenUpdating()
                ->hideFromDetail()
                ->hideFromIndex(),
            NovaDependencyContainer::make([
                Select::make('AP', 'old_transmitter')
                    ->options(
                        Transmitter::where('mode', 'AP')->pluck('ssid', 'id')
                    ),
            ])->dependsOn('mode', 'STA')
                ->hideWhenUpdating()
                ->hideFromDetail()
                ->hideFromIndex(),
            Text::make('SSID')
                ->sortable()
                ->hideWhenUpdating()
                ->hideWhenCreating(),
            Text::make('Password')
                ->sortable()
                ->hideWhenUpdating()
                ->hideWhenCreating()
                ->hideFromIndex(),
            Text::make('Location')
                ->sortable()
                ->hideWhenCreating()
                ->hideFromIndex(),

            Select::make('Team', 'team_id')->options(
                \App\Team::all()->pluck('name', 'id')
            )->withMeta(['value'=>(isset($this->team_id)) ? $this->team_id : ''])
                ->nullable()
                ->hideFromIndex()
                ->hideFromDetail()
                ->hideWhenCreating(),

            NovaDependencyContainer::make([
                NovaBelongsToDepend::make('Site')
                    ->options(\App\Site::all())
                    ->dependsOn('Team')->nullable(),
            ])->dependsOnNotEmpty('team_id')
                ->hideWhenCreating(),
            NovaDependencyContainer::make([
                NovaBelongsToDepend::make('Ifu')
                    ->dependsOn('Site')->nullable(),
            ])->dependsOnNotEmpty('team_id')
                ->hideWhenCreating(),
            NovaDependencyContainer::make([
                NovaBelongsToDepend::make('Assembly')
                    ->options(\App\Assembly::all())
                    ->nullable(),
            ])->dependsOn('team_id', '')
                ->hideWhenCreating(),
            NovaBelongsToDepend::make('TransmitterType')
                ->options(\App\TransmitterType::all())
                ->singularLabel('Transmitter Type'),
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
