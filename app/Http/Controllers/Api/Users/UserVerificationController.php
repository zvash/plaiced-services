<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        // TODO: Redirect to success or verified page.
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
