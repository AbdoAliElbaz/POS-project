<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\clientLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function clientLoginForm()
    {
        return view('auth.clients.login');
    }

    public function clientLogin(clientLoginRequest $request)
    {
        // dd($request);
        if (auth('clients')->attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            return redirect()->route('front.index');
        }

        $errors = ['email' => 'Invalid Email or Password'];
        return back()->withErrors($errors);
    }

    public function clientLogout() {
        auth('clients')->logout();
        return redirect()->route('front.index');

    }
}
