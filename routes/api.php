<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/users/login', 'AuthController@login');
Route::post('/users/refresh', 'AuthController@refresh');
Route::post('/users/logout', 'AuthController@logout');
Route::post('/users/signup', 'UsersController@store');
Route::post('/users/forgot-password', 'UsersController@forgotPassword');
Route::post('/users/reset-password/{token}', 'UsersController@resetForgottenPassword');
Route::get('/teams/accept-invite/{token}', 'TeamsController@acceptInviteToTeam')->name('teams.accept_invite');
Route::get('/users/verify', 'UsersController@verify')->name('verification.verify');

Route::middleware(['auth:api', 'verified'])->group(
    function () {
        Route::get('/users', 'UsersController@index')->name('users.index');
        Route::put('/users', 'UsersController@update');
        Route::post('/users/update-password', 'UsersController@updatePassword');
        Route::post('/teams', 'TeamsController@store');
        Route::get('/users/permissions', 'UsersController@getCameraPermission');

        Route::middleware(['hasCurrentTeam'])->group(
            function () {
                Route::get('/teams', 'TeamsController@index');
                Route::get('/teams/{id}', 'TeamsController@show');
                Route::get('/teams/{id}/invites', 'TeamsController@teamInvites');
                Route::put('/teams', 'TeamsController@update');
                Route::delete('/teams/{team}', 'TeamsController@destroy');
                Route::delete('/teams/user/{user}', 'TeamsController@removeUserFromTeam');
                Route::post('/teams/switch/{team}', 'TeamsController@switchUserTeam');
                Route::put('/teams/user/{user}', 'TeamsController@changeUserRole');
                Route::post('/teams/invite/{email}', 'TeamsController@inviteUserToTeam');
                Route::post('/teams/invite/{invitation}/resend', 'TeamsController@resendInvitationToUser');
                Route::delete('/teams/invite/{invitation}', 'TeamsController@destroyInvitation');
                Route::get('/sites', 'SitesController@index');
                Route::get('/sites/{id}', 'SitesController@show');
                Route::put('/sites/{id}', 'SitesController@update');
                Route::post('/sites', 'SitesController@store');
                Route::get('/ifus', 'IfusController@index');
                Route::get('/ifus/{id}', 'IfusController@show');
                Route::put('/ifus/{id}', 'IfusController@update');
                Route::post('/ifus/{id}/disassociate', 'IfusController@disassociateIfu');
                Route::get('/transmitters', 'TransmittersController@index');
                Route::get('/transmitters/{id}', 'TransmittersController@show');
                Route::put('/transmitters/{id}', 'TransmittersController@update');
                Route::post('/transmitters/{id}/disassociate', 'TransmittersController@disassociateTransmitter');
                Route::get('/cameras', 'CamerasController@index');
                Route::get('/cameras/{id}', 'CamerasController@show');
                Route::put('/cameras/{id}', 'CamerasController@update');
                Route::post('/cameras/{id}/disassociate', 'CamerasController@disassociateCamera');
                Route::get('/cameras/{id}/permissions', 'CamerasController@getCameraPermissions');
                Route::put('/cameras/{id}/permissions', 'CamerasController@updateCameraPermissions');
                Route::get('/views', 'ViewsController@index');
                Route::get('/views/{id}', 'ViewsController@show');
                Route::post('/views', 'ViewsController@store');
                Route::put('/views/{id}', 'ViewsController@update');
                Route::delete('/views/{id}', 'ViewsController@destroy');
                Route::post('/license-keys/validate/{license}', 'DevicesController@validateLicense');
                Route::post('/license-keys/associate/{license}', 'DevicesController@associateDevice');
                Route::get('/devices', 'DevicesController@index');
            }
        );
    }
);
