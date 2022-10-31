<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Gate;

class VerificationMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            if (!auth()->user()->verified) {
                auth()->logout();

                //return redirect()->route('login')->with('message', trans('global.verifyYourEmail'));
                return response(view('auth.login')->withMessages(trans("Please complete your email verification. <a href='".route('resendVerification')."'> Resend Verification. </a>")));
            }
        }

        return $next($request);
    }
}
