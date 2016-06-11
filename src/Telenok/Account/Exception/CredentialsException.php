<?php

namespace Illuminate\Validation;

use Exception;

class CredentialsException extends Exception
{
    /**
     * The recommended response to send to the client.
     *
     * @var \Illuminate\Http\Response|null
     */
    public $response;

    /**
     * Create a new exception instance.
     *
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function __construct($response = null)
    {
        parent::__construct('These credentials do not match our records.');

        $this->response = $response;
    }

    /**
     * Get the underlying response instance.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
