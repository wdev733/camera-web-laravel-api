<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Controller;
use App\Http\Resources\IfuPermissionCollection;
use App\Ifu;
use App\Repository\UserRepository;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    use SendsPasswordResetEmails, ResetsPasswords {
        SendsPasswordResetEmails::broker insteadof ResetsPasswords;
        ResetsPasswords::credentials insteadof SendsPasswordResetEmails;
    }
    private $repository;
    public function __construct()
    {
        $this->repository = new UserRepository;
        $this->middleware('signed')->only('verify');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = auth('api')->user();

        if ($user->currentTeam) {
            $user->role = $user->getCurrentTeamRoleAttribute();
        }
        unset($user->email_verified_at);
        unset($user->current_team_id);
        return response()->json($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->repository->createUser($request);
        return response()->json(['message'=>'We\'ve sent you an email to verify your account.'], 201);
    }

    public function verify(Request $request)
    {
        $response = VerificationController::verify($request);
        return redirect(config('teamwork.email_verification_success'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $user_update = $this->repository->updateUser($request, auth('api')->user());
        return response()->json($user_update, 200);
    }

    public function forgotPassword(Request $request)
    {
        $this->sendResetLinkEmail($request);
        return response()->json(['message'=>'Password recovery instructions have been sent to your email address.'], 200);
    }

    public function resetForgottenPassword(Request $request, $token)
    {
        $request->merge(['token'=> $token]);
        $this->reset($request);
        return response()->json(['message'=>'Password changed.'], 200);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'repeat_password' => 'required',
        ]);
        $user = auth('api')->user();
        $password = $request->old_password;
        if (! Hash::check($password, $user->password)) {
            return response()->json(['message'=>'Wrong old password.'], 404);
        }
        if ($request->new_password !== $request->repeat_password) {
            return response()->json(['message'=>'Password confirmation does not match.'], 404);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json(['message'=>'Password updated.'], 200);
    }

    public function getCameraPermission()
    {
        $user = auth('api')->user();
        $response = [];
        $teams = User::with('teams')->find($user->id);
        if (! count($teams->teams)) {
            $json_encoded = json_encode($response);
            $response = $this->encrypt($json_encoded);
            return $response;
        }
        $teamIds = [];
        foreach ($teams->teams as $team) {
            array_push($teamIds, $team->id);
        }
        $ifus = Ifu::with('cameras')->whereIn('team_id', $teamIds)->get();
        $json_encoded = json_encode(new IfuPermissionCollection($ifus));
        $response = $this->encrypt($json_encoded);
        return response()->json($response);
    }
    public function encrypt($plain_text)
    {
        $salt = openssl_random_pseudo_bytes(256);
        $iv = openssl_random_pseudo_bytes(16);
        $iterations = 999;
        $key = hash_pbkdf2('sha512', Config::get('onvp.proxy_encryption_key'), $salt, $iterations, 64);
        $encrypted_data = openssl_encrypt($plain_text, Config::get('app.cipher'), hex2bin($key), OPENSSL_RAW_DATA, $iv);
        $data = ['ciphertext' => base64_encode($encrypted_data), 'iv' => bin2hex($iv), 'salt' => bin2hex($salt)];
        return $data;
    }
}
