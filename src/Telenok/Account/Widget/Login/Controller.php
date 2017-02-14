<?php

namespace Telenok\Account\Widget\Login;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use App\Vendor\Telenok\Account\Factory\Provider;
use App\Vendor\Telenok\Core\Model\User\User;
use Telenok\Account\Exception\CredentialsException;
use Telenok\Account\Exception\LockoutException;
use Telenok\Account\Abstraction\ValidatesRequests;
use Illuminate\Validation\ValidationException;

class Controller extends \App\Vendor\Telenok\Core\Abstraction\Widget\Controller
{

    use ThrottlesLogins, ValidatesRequests;

    /**
     * @protected
     * @property {String} $key
     * Key of widget.
     * @member Telenok.Account.Widget.Login.Controller
     */
    protected $key = 'login';

    /**
     * @protected
     * @property {String} $parent
     * Parent's widget key.
     * @member Telenok.Account.Widget.Login.Controller
     */
    protected $parent = 'account';

    /**
     * @protected
     * @property {String} $defaultFrontendView
     * Name of view for fronend if user dont want to create own view.
     * @member Telenok.Account.Widget.Login.Controller
     */
    protected $defaultFrontendView = "account::widget.login.widget-frontend";

    /**
     * @protected
     * @property {String} $usernameField
     * Value of attribute "name" in login input-field. Used for searching user in DB etc. Can be also "email" and
     *     others.
     * @member Telenok.Account.Widget.Login.Controller
     */
    protected $usernameField = "username";

    /**
     * @protected
     * @property {Integer} $maxLoginAttempts
     * Max attempts to login.
     * @member Telenok.Account.Widget.Login.Controller
     */
    protected $maxLoginAttempts = 5;

    /**
     * @protected
     * @property {Integer} $lockoutTime
     * The number of seconds to delay further login attempts.
     * @member Telenok.Account.Widget.Login.Controller
     */
    protected $lockoutTime = 60;

    /**
     * @protected
     * @property {String} $guard
     * The guard to be used during authentication.
     * @member Telenok.Account.Widget.Login.Controller
     */
    protected $guard = 'web';

    /**
     * @protected
     * @property {String} $redirectAfterLogin
     * The post login redirect path.
     * @member Telenok.Account.Widget.Login.Controller
     */
    protected $redirectAfterLogin;

    /**
     * @protected
     * @property {String} $routeLogin
     * Name of route for login.
     * @member Telenok.Account.Widget.Login.Controller
     */
    protected $routeLogin = "telenok.account.login";


    /**
     * Create a new widget instance.
     *
     * @return void
     * @member Telenok.Account.Widget.Login.Controller
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * @method setConfig
     * Set config of widget
     *
     * @param {Array} $config
     *
     * @member Telenok.Account.Widget.Login.Controller
     * @return {Telenok.Account.Widget.Login.Controller}
     */
    public function setConfig($config = [])
    {
        $config = collect($config)->all();

        parent::setConfig(array_merge($config, [
            'route_login'        => array_get($config, 'route_login', $this->routeLogin),
            'username_field'     => array_get($config, 'username_field', $this->usernameField),
            'max_login_attempts' => array_get($config, 'max_login_attempts', $this->maxLoginAttempts),
            'lockout_time'       => array_get($config, 'lockout_time', $this->lockoutTime),
            'guard'              => array_get($config, 'guard', $this->guard),
            'redirect_after_login' => array_get($config, 'redirect_after_login', $this->redirectAfterLogin),
        ]));

        $this->routeLogin = $this->getConfig('route_login');
        $this->usernameField = $this->getConfig('username_field');
        $this->maxLoginAttempts = $this->getConfig('max_login_attempts');
        $this->lockoutTime = $this->getConfig('lockout_time');
        $this->guard = $this->getConfig('guard');
        $this->redirectAfterLogin = $this->getConfig('redirect_after_login');

        return $this;
    }

    /**
     * @method getRouteLogin
     * Return name of login route
     * @member Telenok.Account.Widget.Login.Controller
     * @return {String}
     */
    public function getRouteLogin()
    {
        return $this->routeLogin;
    }

    /**
     * @method username
     * For trait ThrottlesLogins
     * @member Telenok.Account.Widget.Login.Controller
     * @return {String}
     */
    public function username()
    {
        return $this->usernameField;
    }

    /**
     * @method getMaxLoginAttempts
     * Max attempts to login.
     * @member Telenok.Account.Widget.Login.Controller
     * @return {Integer}
     */
    public function getMaxLoginAttempts()
    {
        return $this->maxLoginAttempts;
    }

    /**
     * @method getLockoutTime
     * Return name of login input-field
     * @member Telenok.Account.Widget.Login.Controller
     * @return {String}
     */
    public function getLockoutTime()
    {
        return $this->lockoutTime;
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return string
     */
    public function getGuard()
    {
        return $this->guard;
    }

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    public function getRedirectAfterLogin()
    {
        return $this->redirectAfterLogin;
    }

    /**
     * Handle a login request to the application.
     *
     * @param  {Illuminate.Http.Request} $request
     *
     * @return {Illuminate.Http.Response}
     * @member Telenok.Account.Widget.Login.Controller
     */
    public function postLogin(Request $request)
    {
        try
        {
            return $this->login($request);
        }
        catch (ValidationException $e)
        {
            return $e->getResponse();
        }
        catch (LockoutException $e)
        {
            return $e->getResponse();
        }
        catch (CredentialsException $e)
        {
            return $e->getResponse();
        }
    }

    /**
     * Handle a login request to the application.
     *
     * @param  {Illuminate.Http.Request} $request
     *
     * @return {Illuminate.Http.Response}
     * @member Telenok.Account.Widget.Login.Controller
     */
    protected function login(Request $request)
    {
        $this->validateLogin($request);

        if ($lockedOut = $this->hasTooManyLoginAttempts($request))
        {
            $this->fireLockoutEvent($request);

            $this->throwLockoutException($request);
        }

        $credentials = $this->getCredentials($request);

        if (app('auth')->guard($this->getGuard())->attempt($credentials, $request->has('remember')))
        {
            return $this->buildSucessedResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if (!$lockedOut)
        {
            $this->incrementLoginAttempts($request);
        }

        $this->throwCredentialsException($request);
    }

    /**
     * Get user logout.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function getLogout()
    {
        app('auth')->logout();

        $redirect = urldecode($this->getRequest()->get('redirect')) ?: $this->getPreviousUrl();

        return redirect()->intended($redirect);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Validate the user login request.
     *
     * @param  {Illuminate.Http.Request} $request
     *
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validateRequest($request, [
            $this->username() => 'required', 'password' => 'required',
        ]);
    }

    /**
     * Format the lockout errors to be returned.
     *
     * @param {Illuminate.Http.Request} $request
     *
     * @return array
     */
    protected function formatLockoutErrors(Request $request)
    {
        return [$this->LL('error.login.lockout', ['seconds' => $this->secondsRemainingOnLockout($request)])];
    }

    /**
     * Format the validation errors to be returned.
     *
     * @param {Illuminate.Http.Request} $request
     *
     * @return array
     */
    protected function formatCredentialsErrors(Request $request)
    {
        return [$this->LL('error.login.credentials')];
    }

    /**
     * Redirect to social network site.
     *
     * @param {String} $name Key of social network
     *
     * @return array
     */
    public function redirectToProvider($name = '')
    {
        $this->getRequest()->session()->flash('redirectPath', app('request')->get('redirect'));

        return app(Provider::class)
                    ->create($name, ['redirect' => route('telenok.account.redirect-to-provider', ['name' => $name])])
                    ->redirect();
    }

    /**
     * Process callback from social network site.
     *
     * @param {String} $name Key of social network
     *
     * @return array
     */
    public function handleProviderCallback($name = '')
    {
        $user = app(Provider::class)
            ->create($name)
            ->user();

        $email = $user->getId() . '_' . $user->getEmail() . '.net' . $name;
        $nick = $user->getNickname() ?: $name . '.' . date('YmdHiu');

        try
        {
            $cmsUser = User::where('email', $email)->firstOrFail();

            app('auth')->login($cmsUser, true);
        }
        catch (\Exception $e)
        {
            $cmsUser = app(User::class)->storeOrUpdate([
                'title'     => $email,
                'username'  => $email,
                'email'     => $email,
                'usernick'  => $nick,
                'firstname' => ($user->getName() ?: $nick),
                'password'  => app('hash')->make(uniqid()),
                'active'    => 1,
            ]);

            app('auth')->login($cmsUser, true);
        }

        return redirect()->intended(urldecode($this->getRequest()->session()->get('redirectPath', '/')));
    }
}
