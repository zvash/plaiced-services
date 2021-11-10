<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class UserVerificationController extends Controller
{
    /**
     * User verification controller constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->only('resend');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1');
    }

    /**
     * Verify user email.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            // TODO: Redirect to already verified page.
            return response(['message' => 'Already verified.']);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // TODO: Redirect to success page.
        return response(['message' => 'verified.']);
    }

    /**
     * Resend verification email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return response()->noContent();
    }
}
