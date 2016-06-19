
{!! $controller->LL('email.reset', ['url' => route('telenok.account.reset.process', [
        'token' => $token,
        'email' => $user->email,
        'cache_key' => $controller->getConfig('cache_key'),
    ])]) !!}
