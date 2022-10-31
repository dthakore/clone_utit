<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserVerificationController extends Controller
{
    public function approve($token)
    {
        $user = User::where('verification_token', $token)->first();
        abort_if(!$user, 404);

        $user->verified           = 1;
        $user->verified_at        = Carbon::now()->format(config('panel.date_format') . ' ' . config('panel.time_format'));
        $user->verification_token = null;
        $user->save();

        return redirect()->route('login')->with('message', trans('global.emailVerificationSuccess'));
    }
    public function resendVerification()
    {
        return view('auth.resend');
    }
    protected function validateVerificationSubmit(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'This email is not exists. Please check your email.'
        ]);
    }
    public function resendVerificationSubmit(Request $request)
    {
        $validator = $this->validateVerificationSubmit($request->all());
        if($validator->errors()->any()) {
            return view('auth.resend')->withErrors($validator->errors()->toArray());
        }else{
            $user = User::where('email',$request->email)
            ->where('verified',0)
            ->first();
            if($user == null){
                return view('auth.resend')->withErrors(['email' => 'User is already verified.']);
            }else{
                $token = Str::random(64);
                User::where('id','=', $user->id)
                    ->update([
                        "verification_token" => $token
                    ]);
                $user->resentVerificationMail($user->id);
                
                return response(view('auth.login')->withMessages(trans("Verification Email Resent to your Email")));

            }
        }
    }
}
