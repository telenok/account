<?php

namespace Telenok\Account\Abstraction;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Validation\ValidationException;
use Telenok\Account\Exception\CredentialsException;
use Telenok\Account\Exception\LockoutException;

trait ValidatesRequests {

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

        return redirect()->intended($this->getRequest()->get('redirect') ?: '');
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

