<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ItemCategory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        $username = $request->username;
        $password = $request->password;

        $fieldType = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'user_email' : 'user_name';
        if (Auth::attempt([$fieldType => $username, 'password' => $password])) {
            $user = Auth::user();
            $attributes = ['user_id' => $user->user_id, 'user_name' => $user->user_name, 'user_status', 'user_fullname' => $user->user_fullname];
            $menu = ItemCategory::get();
            if (count($menu) > 0) Session::put('categories', $menu);
            if (count($menu) == 0) Session::put('categories', []);
            Session::put('user', $attributes);
            return redirect()->route('admin.dashboard');
        } else {
            return back()->withErrors(['password' => 'Email atau password salah']);

        }

    }
}
