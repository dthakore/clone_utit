<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'     => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'confirmed', 'regex:/^(?=.{8,})(?=.*[A-Z])(?=.*[@#!$%^&+=]).*$/'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\User
     */
    protected function create(array $data)
    {
        //dd('hello');
        session(['audit_log' => "New user registered", 'audit_log_category' => "Register"]);

        return User::create([
            'name'          => $data['first_name']. " ".$data['last_name'],
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'email'    => $data['email'],
            'sponsor_id'    => $data['sponsor_id'],
            'password' => Hash::make($data['password']),
            'product_id' => 1
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm(Request $request)
    {
        $user = User::where('id','=', $request->id)->first();
        if($user) {
            return view('auth.register');
        } else {
            return abort(404);
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if($validator->errors()->any()) {
            return view('auth.register')->withInput($request->flashExcept('password'))->withErrors($validator->errors()->toArray());
        } else {
            event(new Registered($user = $this->create($request->all())));
            //$this->guard()->login($user);
            if ($response = $this->registered($request, $user)) {
                return $response;
            }
            return $request->wantsJson() ? new JsonResponse([], 201) : view('auth.login')->withMessages('We have sent you a confirmation mail. Please activate before logging in.');
        }
    }
}
