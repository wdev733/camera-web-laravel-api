<?php

namespace App\Repository;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function createUser($request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ]);
        $user = new User;
        $user->email = $request->email;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->sendEmailVerificationNotification();

        return $user;
    }

    public function updateUser($request, $user)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'dark_theme' => 'required|boolean',
        ]);

        $user->email = $request->email;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->dark_theme = $request->dark_theme;
        $user->save();

        return $user;
    }
}
