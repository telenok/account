<?php

namespace Telenok\Account\Widget\ResetPassword;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Telenok\Account\Abstraction\ValidatesRequests;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use App\Telenok\Account\Broker\PasswordBroker;

class Controller extends \App\Telenok\Core\Abstraction\Widget\Controller {

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
    protected $defaultFrontendView = "account::widget.reset-password.widget-frontend-email";

    /**
     * @protected
     * @property {String} $defaultFrontendView
     * Name of view for fronend if user dont want to create own view.
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    protected $emailFrontendView = "account::widget.reset-password.email.password";

    /**
     * @protected
     * @property {String} $defaultFrontendView
     * Name of view for fronend if user dont want to create own view.
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
        parent::setConfig($config);

        if ($m = $this->getWidgetModel())
        {
            $structure = $m->structure;

            $this->routeReset = array_get($structure, 'route_reset');
            $this->broker = array_get($structure, 'broker');
            $this->guard = array_get($structure, 'guard');
            $this->emailFrom = array_get($structure, 'email_from');
            $this->emailSenderName = array_get($structure, 'email_sender_name');
            $this->emailSubject = array_get($structure, 'email_subject');
            $this->resetFrontendView = array_get($structure, 'reset_frontend_view');
            $this->emailFrontendView = array_get($structure, 'email_frontend_view');
            $this->redirectResetEmail = array_get($structure, 'redirect_reset_email');
        }
        else
        {
            $this->routeReset = $this->getConfig('route_reset', $this->routeReset);
            $this->broker = $this->getConfig('broker', $this->broker);
            $this->guard = $this->getConfig('guard', $this->guard);
            $this->emailFrom = $this->getConfig('email_from', $this->emailFrom);
            $this->emailSenderName = $this->getConfig('email_sender_name', $this->emailSenderName);
            $this->emailSubject = $this->getConfig('email_subject', $this->emailSubject);
            $this->resetFrontendView = $this->getConfig('reset_frontend_view', $this->resetFrontendView);
            $this->emailFrontendView = $this->getConfig('email_frontend_view', $this->emailFrontendView);
            $this->redirectResetEmail = $this->getConfig('redirect_reset_email', $this->redirectResetEmail);
        }

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
            return $this->sendResetLinkEmail($request);
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

        return view($this->getFrontendView(), ['controller' => $this])->render();
    }

    /**
     * Redirect to show reset form for new password
     *
     * @member Telenok.Account.Widget.ResetPassword.Controller
     */
    public function redirectToResetForm(Request $request, $token)
    {
        return redirect()->to($request->get('redirect'))->withInput([
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
        $user->password = bcrypt($password);

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
        return redirect()->back()->with('status', trans($response));
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
            ->withInput($request->only('email', 'token'))
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
