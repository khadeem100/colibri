<?php
/*
|--------------------------------------------------------------------------
| ColibriPlus - The Social Network Web Application.
|--------------------------------------------------------------------------
| Author: Mansur Terla. Full-Stack Web Developer, UI/UX Designer.
| Website: www.terla.me
| E-mail: mansurtl.contact@gmail.com
| Instagram: @mansur_terla
| Telegram: @mansurtl_contact
|--------------------------------------------------------------------------
| Copyright (c)  ColibriPlus. All rights reserved.
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers\User\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\EmailConfirmation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Actions\User\CreateUserAction;
use Illuminate\Support\Facades\Validator;
use App\Events\User\Auth\UserLoggedInEvent;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth::index');
    }

    public function signup()
    {
        return view('auth::signup');
    }

    public function forgotPassword()
    {
        return view('auth::forgot');
    }

    public function resetPassword(string $token)
    {
        $confirmationData = $this->getTokenData($token);

        return view('auth::reset', [
            'confirmationData' => $confirmationData
        ]);
    }

    public function forgotSuccess(string $token)
    {
        $confirmationData = $this->getTokenData($token);

        return view('auth::forgot-success', [
            'confirmationData' => $confirmationData
        ]);
    }

    public function signupSuccess(string $token)
    {
        $confirmationData = $this->getTokenData($token);

        return view('auth::signup-success', [
            'confirmationData' => $confirmationData
        ]);
    }

    public function confirmSignup(string $token)
    {
        $confirmationData = $this->getTokenData($token);
        
        $tempUsername = Str::before($confirmationData->email, '@');

        $tempUsernameTaken = User::where('username', $tempUsername)->exists();

        if($tempUsernameTaken) {
            $emailDomain = Str::before(Str::after($confirmationData->email, '@'), '.');

            $tempUsername = "{$tempUsername}_{$emailDomain}";

            $tempUsernameTaken = User::where('username', $tempUsername)->exists();

            if($tempUsernameTaken) {
                
                $lastUserId = User::max('id');

                $lastUserId = (is_integer($lastUserId)) ? ($lastUserId + 1) : 1;

                $usernamePrefix = config('user.username_prefix');

                $tempUsername = "{$usernamePrefix}{$lastUserId}";
            }
        }

        $insertData = [
            'email' => $confirmationData->email,
            'username' => $tempUsername
        ];
        
        $newUser = (new CreateUserAction($insertData))->execute();

        Auth::guard('web')->login($newUser, true);

        event(new UserLoggedInEvent(me()));

        $confirmationData->delete();

        return redirect()->route('user.onboarding.index', 'one');
    }

    private function getTokenData($token)
    {
        $validator = Validator::make([
            'token' => $token
        ], [
            'token' => ['required', 'string', 'uuid']
        ]);

        if($validator->fails()) {
            abort(404);
        }

        return EmailConfirmation::where('token', $token)->firstOrFail();
    }
}
