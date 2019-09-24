<?php

namespace App\Nova;

use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Epartment\NovaDependencyContainer\HasDependencies;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Orlyapps\NovaBelongsToDepend\NovaBelongsToDepend;
use RuggedNetworks\NovaStringWithButton\StringWithButton;
use Wemersonrv\InputMask\InputMask;

class Ifu extends Resource
{
    use HasDependencies;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Ifu';

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
        'id', 'mac', 'license_key', 'vpn_ip',
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
                ->rules('required', 'string', 'unique:ifus,mac,{{resourceId}}', 'regex:/^[0-9A-F]*$/', 'size:12'),
            Text::make('VPN IP')
                ->sortable()
                ->rules('ipv4', 'nullable')
                ->hideWhenCreating(),
            Text::make('Location')
                ->sortable()
                ->hideWhenCreating()
                ->hideFromIndex(),
            StringWithButton::make('Api Key')
                ->hideWhenUpdating()
                ->hideWhenCreating()
                ->hideFromIndex(),
            StringWithButton::make('Secret Key')
                ->hideWhenUpdating()
                ->hideWhenCreating()
                ->hideFromIndex(),
            StringWithButton::make('Vpn Password')
                ->hideWhenUpdating()
                ->hideWhenCreating()
                ->hideFromIndex(),
            Text::make('Vpn Server')
                ->sortable()
                ->rules('max:255')
                ->hideWhenCreating(),
            NovaBelongsToDepend::make('Team')
                ->nullable()
                ->options(\App\Team::all())
                ->hideWhenCreating(),
            NovaBelongsToDepend::make('Site')
                ->nullable()
                ->optionsResolve(function (\App\Team $team) {
                    return $team->sites()->get(['id','name']);
                })
                ->dependsOn('Team')
                ->hideWhenCreating(),
            NovaDependencyContainer::make([
                BelongsTo::make('Assembly')
                ->nullable(),
            ])->dependsOn('team_id', '')
                ->hideWhenCreating(),
            NovaBelongsToDepend::make('IfuType')
                ->options(\App\IfuType::all())
                ->singularLabel('Ifu Type'),
        ];
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'IFUs';
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
