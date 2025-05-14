<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAdminRequest;
use App\Models\CoreRole;
use App\Models\CoreUser;
use App\Models\MstPpat;
use App\Models\TBilling;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

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
    use AuthenticatesUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo    = 'admin.dashboard';

    /**
     * Max login attempts allowed.
     */
    public $maxAttempts     = 5;

    /**
     * Number of minutes to lock the login.
     */
    public $decayMinutes    = 3;

    /**
     * Namespace for page view
     */
    private $namespace      = 'pages.auth.';

    /**
     * Guard name for authentication
     */
    private $guard_name      = 'admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:' . $this->guard_name)->except('logout');
    }

    public function index()
    {
        if (Auth::guard($this->guard_name)->user())
            return redirect()->route($this->redirectTo);

        return view($this->namespace . 'login');
    }

    public function authenticate(LoginAdminRequest $request)
    {
        //check if the user has too many login attempts.
        if ($this->hasTooManyLoginAttempts($request)) {
            //Fire the lockout event.
            $this->fireLockoutEvent($request);

            //redirect the user back after lockout.
            return $this->sendLockoutResponse($request);
        }

        //attempt login.
        if (Auth::guard($this->guard_name)->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            //Authenticated
            return redirect()
                ->intended(route($this->redirectTo));
        }

        //keep track of login attempts from the user.
        $this->incrementLoginAttempts($request);

        //Authentication failed
        return redirect()
            ->back()
            ->withInput()
            ->with('error', Lang::get('auth.failed'));
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard($this->guard_name);
    }

    public function logout(Request $request)
    {
        if (Auth::guard($this->guard_name)->check()) {

            Auth::guard($this->guard_name)->logout();
            return redirect()->route('auth.login');
        }

        $this->guard()->logout();
        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }
}
