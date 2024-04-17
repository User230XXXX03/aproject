<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Create a login from
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Login api
     */
    public function login(Request $request)
    {
        // Validate parameters
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Attempt to find the user
        $user = User::where('username', $credentials['username'])->first();

        // If the user does not exist or the password is incorrect, return error messages
        if (!$user || !password_verify($credentials['password'], $user->password)) {
            return back()->withErrors([
                'username' => 'Please Enter The CORRECT ACCOUNT OR PASSWORD.', // Combined error message
                'password' => 'Please Enter The CORRECT ACCOUNT OR PASSWORD.', // Combined error message
            ]);
        }

        // If verification is successful, store user information in the session and redirect to the homepage
        session()->put('user', $user);
        return redirect()->intended('/');
    }
}
