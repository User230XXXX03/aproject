<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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


    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * @param array $data
     * @return bool
     */
    protected function insert(array $data)
    {
        return DB::table('users')->insert([
            'username' => htmlspecialchars($data['username']),//Convert predefined HTML tags into entity symbols to prevent injection
            'email' => htmlspecialchars($data['email']),//Convert predefined HTML tags into entity symbols to prevent injection
            'password' => Hash::make($data['password']),
        ]);
    }

    // app/Http/Controllers/Auth/RegisterController.php

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $params = $request->post();
        $validator = $this->validator($params);
        if ($validator->fails()) {
            return redirect('/register')
                ->withErrors($validator)
                ->withInput();
        }

        if (!$this->insert($params)){
            // Insertion failed with error message returned
            return redirect()->back()->withErrors(['message' => 'Registration failed, please try again.']);
        }

        $user = User::where(['username'=>$params['username']])->first();
        if ($user) {
            session()->put('user',$user);
            // Login successful, perform redirection or other operations
            return redirect()->intended('/')->with('success', 'Registration successful, I thought you would automatically log in.');
        }
    }
}
