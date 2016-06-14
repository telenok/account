<?php

namespace Telenok\Account\Broker;

use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract; 
use Closure;

class PasswordBroker extends \Illuminate\Auth\Passwords\PasswordBroker {

    /**
     * Constant representing a successfully sent reminder.
     *
     * @var string
     */
    const RESET_LINK_SENT = 'account::widget/reset-password.passwords.sent';

    /**
     * Constant representing a successfully reset password.
     *
     * @var string
     */
    const PASSWORD_RESET = 'account::widget/reset-password.passwords.reset';

    /**
     * Constant representing the user not found response.
     *
     * @var string
     */
    const INVALID_USER = 'account::widget/reset-password.passwords.user';

    /**
     * Constant representing an invalid password.
     *
     * @var string
     */
    const INVALID_PASSWORD = 'account::widget/reset-password.passwords.password';

    /**
     * Constant representing an invalid token.
     *
     * @var string
     */
    const INVALID_TOKEN = 'account::widget/reset-password.passwords.token';


    /**
     * Set the view of the password reset link e-mail.
     *
     * @var string
     * @return void
     */
    public function setEmailView($view)
    {
        $this->emailView = $view;

        return $this;
    }

    /**
     * Send a password reset link to a user.
     *
     * @param  array  $credentials
     * @param  \Closure|null  $callback
     * @return string
     */
    public function sendResetLink(array $credentials, Closure $callback = null, array $additionalParams = array())
    {
        // First we will check to see if we found a user at the given credentials and
        // if we did not we will redirect back to this current URI with a piece of
        // "flash" data in the session to indicate to the developers the errors.
        $user = $this->getUser($credentials);

        if (is_null($user)) {
            return static::INVALID_USER;
        }

        // Once we have the reset token, we are ready to send the message out to this
        // user with a link to reset their password. We will then redirect back to
        // the current URI having nothing set in the session to indicate errors.
        $token = $this->tokens->create($user);

        $this->emailResetLink($user, $token, $callback, $additionalParams);

        return static::RESET_LINK_SENT;
    }

    /**
     * Send the password reset link via e-mail.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $token
     * @param  \Closure|null  $callback
     * @return Integer
     */
    public function emailResetLink(CanResetPasswordContract $user, $token, Closure $callback = null, array $additionalParam = array())
    {
        // We will use the reminder view that was given to the broker to display the
        // password reminder e-mail. We'll pass a "token" variable into the views
        // so that it may be displayed for an user to click for password reset.
        $view = $this->emailView;

        return $this->mailer->send($view, array_merge(compact('token', 'user'), $additionalParam), function ($m) use ($user, $token, $callback)
        {
            $m->to($user->getEmailForPasswordReset());

            if (! is_null($callback)) {
                call_user_func($callback, $m, $user, $token);
            }
        });
    }
}