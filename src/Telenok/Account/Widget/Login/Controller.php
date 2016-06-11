<?php

namespace Telenok\Account\Widget\Login;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Validation\CredentialsException;
use Illuminate\Validation\LockoutException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Controller extends \App\Telenok\Core\Abstraction\Widget\Controller {

    use ThrottlesLogins;

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
     * @property {String} $loginUsername
     * Value of attribute "name" in login input-field. Used for searching user in DB etc. Can be also "email" and others.
     * @member Telenok.Account.Widget.Login.Controller
     */
    protected $loginUsername = "username";

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
    protected $guard;

    /**
     * @protected
     * @property {String} $socialite
     * The list of social networks like 'github, facebook, twitter'.
     * @member Telenok.Account.Widget.Login.Controller
     */
    protected $socialite;

    /**
     * @protected
     * @property {String} $redirectPath
     * The post login redirect path.
     * @member Telenok.Account.Widget.Login.Controller
     */
    protected $redirectPath;

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
     * @param {Array} $config
     * @member Telenok.Account.Widget.Login.Controller
     * @return {Telenok.Account.Widget.Login.Controller}
     */
    public function setConfig($config = [])
    {
        parent::setConfig($config);

        if ($m = $this->getWidgetModel())
        {
            $structure = $m->structure;

            $this->routeLogin = array_get($structure, 'route_login');
            $this->loginUsername = array_get($structure, 'login_username');
            $this->maxLoginAttempts = array_get($structure, 'max_login_attempts');
            $this->lockoutTime = array_get($structure, 'lockout_time');
            $this->guard = array_get($structure, 'guard');
            $this->redirectPath = array_get($structure, 'redirectPath');
            $this->socialite = array_get($structure, 'socialite');
        }
        else
        {
            $this->routeLogin = $this->getConfig('route_login', $this->routeLogin);
            $this->loginUsername = $this->getConfig('login_username', $this->loginUsername);
            $this->maxLoginAttempts = $this->getConfig('max_login_attempts', $this->maxLoginAttempts);
            $this->lockoutTime = $this->getConfig('lockout_time', $this->lockoutTime);
            $this->guard = $this->getConfig('guard', $this->guard);
            $this->redirectPath = $this->getConfig('redirectPath', $this->redirectPath);
            $this->socialite = $this->getConfig('socialite', $this->socialite);
        }

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
     * @method getLoginUsername
     * Return name of login input-field
     * @member Telenok.Account.Widget.Login.Controller
     * @return {String}
     */
    public function getLoginUsername()
    {
        return $this->loginUsername;
    }

    /**
     * @method loginUsername
     * Alias of getLoginUsername() for trait ThrottlesLogins
     * @member Telenok.Account.Widget.Login.Controller
     * @return {String}
     */
    public function loginUsername()
    {
        return $this->loginUsername;
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
    protected function getGuard()
    {
        return $this->guard;
    }

    /**
     * Get the list with social networks.
     *
     * @return string
     */
    protected function getSocialite()
    {
        return $this->socialite;
    }

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    protected function getRedirectPath()
    {
        return $this->redirectPath;
    }

    /**
     * Handle a login request to the application.
     *
     * @param  {Illuminate.Http.Request} $request
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
     * @return {Illuminate.Http.Response}
     * @member Telenok.Account.Widget.Login.Controller
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->throwLockoutException($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            return $this->buildSucessedResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if (!$lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        $this->throwCredentialsException($request);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only($this->getLoginUsername(), 'password');
    }

    /**
     * Validate the user login request.
     *
     * @param  {Illuminate.Http.Request} $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validateRequest($request, [
            $this->getLoginUsername() => 'required', 'password' => 'required',
        ]);
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return void
     */
    public function validateRequest(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }

    /**
     * Get a validation factory instance.
     *
     * @return {Illuminate.Contracts.Validation.Factory}
     */
    protected function getValidationFactory()
    {
        return app(Factory::class);
    }

    /**
     * Throw the failed validation exception.
     *
     * @param {Illuminate.Http.Request} $request
     * @param {Illuminate.Contracts.Validation.Validator} $validator
     * @return void
     *
     * @throws {Illuminate.Foundation.Validation.ValidationException}
     */
    protected function throwValidationException(Request $request, $validator)
    {
        throw new ValidationException($validator, $this->buildFailedResponse(
            $request, $this->formatValidationErrors($validator)
        ));
    }

    /**
     * Throw the failed lockout exception.
     *
     * @param {Illuminate.Http.Request} $request
     * @return void
     *
     * @throws {Illuminate.Foundation.Validation.ValidationException}
     */
    protected function throwLockoutException(Request $request)
    {
        throw new LockoutException($this->buildFailedResponse(
            $request, $this->formatLockoutErrors($request)
        ));
    }

    /**
     * Throw the failed credentials exception.
     *
     * @param {Illuminate.Http.Request} $request
     * @return void
     *
     * @throws {Illuminate.Foundation.Validation.ValidationException}
     */
    protected function throwCredentialsException(Request $request)
    {
        throw new CredentialsException($this->buildFailedResponse(
            $request, $this->formatCredentialsErrors($request)
        ));
    }

    /**
     * Format the validation errors to be returned.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return array
     */
    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->getMessages();
    }

    /**
     * Format the lockout errors to be returned.
     *
     * @param {Illuminate.Http.Request} $request
     * @return array
     */
    protected function formatLockoutErrors(Request $request)
    {
        return $this->LL('error.login.lockout', ['seconds' => $this->secondsRemainingOnLockout($request)]);
    }

    /**
     * Format the validation errors to be returned.
     *
     * @param {Illuminate.Http.Request} $request
     * @return array
     */
    protected function formatCredentialsErrors(Request $request)
    {
        return $this->LL('error.login.credentials');
    }

    /**
     * Create the response for when a request fails.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $errors
     * @return \Illuminate\Http\Response
     */
    protected function buildFailedResponse(Request $request, array $errors)
    {
        if (($request->ajax() && !$request->pjax()) || $request->wantsJson()) {
            return new JsonResponse($errors, 422);
        }

        return redirect()->to($this->getPreviousUrl())
            ->withInput($request->input())
            ->withErrors($errors);
    }

    /**
     * Create the response for when a request successed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function buildSucessedResponse(Request $request)
    {
        if (($request->ajax() && !$request->pjax()) || $request->wantsJson()) {
            return new JsonResponse(['success' => 1], 200);
        }

        return redirect()->intended($this->getRedirectPath());
    }

    /**
     * Get the URL we should redirect to.
     *
     * @return string
     */
    protected function getPreviousUrl()
    {
        return app(UrlGenerator::class)->previous();
    }
}
