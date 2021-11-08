<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class UserVerificationController extends Controller
{
    /**
     * @param EmailVerificationRequest $request
     * @return string
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return 'verified';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return response([
            'message' => 'Verification link sent!'
        ], 200);
    }
}
