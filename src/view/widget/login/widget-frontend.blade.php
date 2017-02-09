@if (app('auth')->check())

    You already logined.

@else
    @if (count($errors) > 0)
        <div>
            {!! $controller->LL('error.login.input') !!}<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{!! route($controller->getRouteLogin()) !!}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="redirect" value="{{ $controller->getRedirectAfterLogin() }}">
        <div>
            <label>{{ $controller->LL('title.login.email') }}</label>
            <div>
                <input type="text" name="{{$controller->username()}}" value="">
            </div>
        </div>

        <div>
            <label>{{ $controller->LL('title.login.password') }}</label>
            <div>
                <input type="password" name="password">
            </div>
        </div>


        <div>
            <div>
                <div>

                    @foreach(['github', 'facebook', 'google', 'linkedin', 'twitter', 'bitbucket'] as $network)

                        <a href="{!! route('telenok.account.redirect-to-provider', ['name' => $network, 'redirect' => urlencode($controller->getRedirectAfterLogin())]) !!}">
                            <img height="70" title="{{$network}}" src="/packages/telenok/account/image/{{$network}}.gif" />
                        </a>

                    @endforeach


                </div>
            </div>
        </div>


        <div>
            <div>
                <div>
                    <label>
                        <input type="checkbox" name="remember" value="1"> {{ $controller->LL('title.login.remember-me') }}
                    </label>
                </div>
            </div>
        </div>

        <div>
            <div>
                <button type="submit">{{$controller->LL('btn.login.send')}}</button>

                <a href="{!! route('telenok.account.password-restore', ['locale' => config('app.locale')]) !!}">
                    {{$controller->LL('title.login.forgot-password')}}
                </a>

            </div>
        </div>

    </form>
@endif
