<?php

namespace Telenok\Account\Widget\ResetPassword;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Telenok\Account\Abstraction\ValidatesRequests;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use App\Vendor\Telenok\Account\Broker\PasswordBroker;

class Controller extends \App\Vendor\Telenok\Core\Abstraction\Widget\Controller {

    use ValidatesRequests;

    /**
     * @protected
     * @property {String} $key
     * Key of widget.
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected $key = 'reset-password';

    /**
     * @protected
     * @property {String} $parent
     * Parent's widget key.
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected $parent = 'account';

    /**
     * @protected
     * @property {String} $defaultFrontendView
     * Name of view for fronend if user dont want to create own view.
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected $defaultFrontendView = "";

    /**
     * @protected
     * @property {String} $initialFrontendView
     * Name of initial view
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected $initialFrontendView = "account::widget.reset-password.widget-frontend-initial";

    /**
     * @protected
     * @property {String} $emailFrontendView
     * Name of email view for the given token to display the password changing link
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected $emailFrontendView = "account::widget.reset-password.widget-frontend-email";

    /**
     * @protected
     * @property {String} $resetFrontendView
     * Name of reset view for the given token to display the password changing
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected $resetFrontendView = "account::widget.reset-password.widget-frontend-reset";

    /**
     * @protected
     * @property {String} $redirectResetEmail
     * Url where redirect user after click on link in content of reset email.
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected $redirectResetEmail = "";

    /**
     * @protected
     * @property {String} $redirectAfterReset
     * Url where redirect user after pasword reset.
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected $redirectAfterReset = "";

    /**
     * @protected
     * @property {String} $broker
     * The broker to be used during password reset.
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected $broker;

    /**
     * @protected
     * @property {String} $emailFrom
     * The email of sender.
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected $emailFrom = 'support@example.com';

    /**
     * @protected
     * @property {String} $emailSender
     * The name of sender.
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected $emailSenderName = 'Support team';

    /**
     * @protected
     * @property {String} $emailSubject
     * The email's subject.
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected $emailSubject;

    /**
     * @protected
     * @property {String} $guard
     * The guard to be used during authentication.
     * @member Telenok.Account.Widget.Login.Controller
     */
    protected $guard = 'web';

    /**
     * @protected
     * @property {String} $routeReset
     * Name of route for reset.
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected $routeReset = "telenok.account.reset";


    /**
     * @method setConfig
     * Set config of widget
     * @param {Array} $config
     * @member Telenok.Account.Widget.ResetPassword.Controller
     * @return {Telenok.Account.Widget.ResetPassword.Controller}
     */
    public function setConfig($config = [])
    {
        $config = collect($config)->all();
        
        parent::setConfig(array_merge($config, [
            'route_reset'           => array_get($config, 'route_reset', $this->routeReset),
            'broker'                => array_get($config, 'broker', $this->broker),
            'guard'                 => array_get($config, 'guard', $this->guard),
            'email_from'            => array_get($config, 'email_from', $this->emailFrom),
            'email_sender_name'     => array_get($config, 'email_sender_name', $this->emailSenderName),
            'email_subject'         => array_get($config, 'email_subject', $this->emailSubject),
            'initial_frontend_view' => array_get($config, 'initial_frontend_view', $this->initialFrontendView),
            'reset_frontend_view'   => array_get($config, 'reset_frontend_view', $this->resetFrontendView),
            'email_frontend_view'   => array_get($config, 'email_frontend_view', $this->emailFrontendView),
            'redirect_reset_email'  => array_get($config, 'redirect_reset_email', $this->redirectResetEmail),
            'redirect_after_reset'  => array_get($config, 'redirect_after_reset', $this->redirectAfterReset),
        ]));

        /*
         * We can restore widget config from cache by cache_key, so set object member value manually
         *
         */
        $this->routeReset           = $this->getConfig('route_reset');
        $this->broker               = $this->getConfig('broker');
        $this->guard                = $this->getConfig('guard');
        $this->emailFrom            = $this->getConfig('email_from');
        $this->emailSenderName      = $this->getConfig('email_sender_name');
        $this->emailSubject         = $this->getConfig('email_subject');
        $this->initialFrontendView  = $this->getConfig('initial_frontend_view');
        $this->resetFrontendView    = $this->getConfig('reset_frontend_view');
        $this->emailFrontendView    = $this->getConfig('email_frontend_view');
        $this->redirectResetEmail   = $this->getConfig('redirect_reset_email');
        $this->redirectAfterReset   = $this->getConfig('redirect_after_reset');

        return $this;
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return string|null
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function getBroker()
    {
        return $this->broker;
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return string
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function getGuard()
    {
        return $this->guard;
    }

    /**
     * Get the route for reset.
     *
     * @return string
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function getRouteReset()
    {
        return $this->routeReset;
    }

    /**
     * Get the email of sender.
     *
     * @return string
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function getEmailFrom()
    {
        return $this->emailFrom;
    }

    /**
     * Get the name of sender.
     *
     * @return string
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function getEmailSenderName()
    {
        return $this->emailSenderName;
    }

    /**
     * Get the email's subject.
     *
     * @return string
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function getEmailSubject()
    {
        return $this->emailSubject;
    }

    /**
     * Get reset view for the given token to display the password changing
     *
     * @return string
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function getResetFrontendView()
    {
        return $this->resetFrontendView;
    }

    /**
     * Get redirect from reset email
     *
     * @return string
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function getRedirectResetEmail()
    {
        return $this->redirectResetEmail ?: app('url')->previous();
    }

    /**
     * Get redirect after reset
     *
     * @return string
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function getRedirectAfterReset()
    {
        return $this->redirectAfterReset;
    }

    /**
     * Get initial form view
     *
     * @return string
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function getInitialFrontendView()
    {
        return $this->initialFrontendView;
    }

    /**
     * Get email view for the given token to display the password changing link
     *
     * @return string
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function getEmailFrontendView()
    {
        return $this->emailFrontendView;
    }

    /**
     * Handle a login request to the application.
     *
     * @param  {Illuminate.Http.Request} $request
     * @return {Illuminate.Http.Response}
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function postResetLinkEmail(Request $request)
    {
        try
        {
            return $this->setConfig(['cache_key' => $request->get('cache_key')])->sendResetLinkEmail($request);
        }
        catch (ValidationException $e)
        {
            return $e->getResponse();
        }
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function sendResetLinkEmail($request)
    {
        $this->validateRequest($request, ['email' => 'required|email']);

        $broker = $this->getBroker();

        $response = Password::broker($broker)->setEmailView($this->getEmailFrontendView())->sendResetLink(
            $request->only('email'), $this->resetEmailBuilder(), ['controller' => $this]
        );

        switch ($response) {
            case PasswordBroker::RESET_LINK_SENT:
                return $this->getSendResetLinkEmailSuccessResponse($response);

            case PasswordBroker::INVALID_USER:
            default:
                return $this->getSendResetLinkEmailFailureResponse($response);
        }
    }

    /**
     * @method getNotCachedContent
     * Return not cached content.
     * @return {String}
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function getNotCachedContent()
    {
        if ($this->getRequest()->session()->hasOldInput('token'))
        {
            $email = $this->getRequest()->get('email');
            $token = $this->getRequest()->session()->get('token');

            return view($this->getResetFrontendView(), ['controller' => $this])->with(compact('token', 'email'));
        }

        return view($this->getInitialFrontendView(), ['controller' => $this])->render();
    }

    /**
     * Redirect to show reset form for new password
     *
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function redirectToResetForm(Request $request, $token)
    {
        return redirect()->to($this->setConfig(['cache_key' => $request->get('cache_key')])->getRedirectResetEmail())->withInput([
            'token' => $token,
            'email' => $request->get('email'),
        ]);
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function reset(Request $request)
    {
        $this->setConfig(['cache_key' => $request->get('cache_key')]);
        $this->validate($request, $this->getResetValidationRules());

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $broker = $this->getBroker();

        $response = Password::broker($broker)->reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        switch ($response) {
            case PasswordBroker::PASSWORD_RESET:
                return $this->getResetSuccessResponse($response);

            default:
                return $this->getResetFailureResetResponse($request, $response);
        }
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected function getResetValidationRules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected function resetPassword($user, $password)
    {
        $user->password = app('hash')->make($password);

        $user->storeOrUpdate();

        app('auth')->guard($this->getGuard())->login($user);
    }

    /**
     * Get the response for after the reset link has been successfully sent.
     *
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected function getSendResetLinkEmailSuccessResponse($response)
    {
        return redirect()->back()->with('status', trans($response));
    }

    /**
     * Get the response for after the reset link could not be sent.
     *
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected function getSendResetLinkEmailFailureResponse($response)
    {
        return redirect()->back()->withErrors(['email' => trans($response)]);
    }

    /**
     * Get the response for after a successful password reset.
     *
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected function getResetSuccessResponse($response)
    {
        return $this->getRedirectAfterReset() ?: redirect()->back()->with('status', trans($response));
    }

    /**
     * Get the response for after a failing password reset.
     *
     * @param  Request  $request
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected function getResetFailureResetResponse(Request $request, $response)
    {
        return redirect()->back()
            ->withInput($request->only('email', 'token', 'cache_key'))
            ->withErrors(['email' => trans($response)]);
    }

    /**
     * Get the Closure which is used to build the password reset email message.
     *
     * @return \Closure
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected function resetEmailBuilder()
    {
        return function (Message $message) {
            $message->subject($this->getEmailSubject()?:$this->LL('email.subject'));
            $message->from($this->getEmailFrom(), $this->getEmailSenderName());
        };
    }

    /**
     * @method getCacheKey
     * Return cache key and add to it new part of key.
     * @param {String} $additional
     * Additional part of key.
     * @return {String}
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function getCacheKey($additional = '')
    {
        return parent::getCacheKey($additional) . ($this->getRequest()->has('token') ? '.token' : '');
    }
}
