
{!! $controller->LL('email.reset', ['url' => route('telenok.account.reset.process', [
        'token' => $token,
        'redirect' => $controller->getRedirectResetEmail(),
        'email' => $user->email
    ])]) !!}
