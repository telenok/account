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
    <input type="hidden" name="redirect" value="{{ $controller->getRedirect() }}">
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

                    @if (config('services.' . $network . '.enabled'))

                        <a href="{!! route('telenok.auth.redirect.social-network', ['name' => $network, 'redirect' => urlencode($controller->getRedirect())]) !!}">
                            <img height="70" title="{{$network}}" src="/packages/telenok/account/image/{{$network}}.gif" />
                        </a>

                    @endif

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

            <a href="{!! route('telenok.auth.password-restore', ['locale' => config('app.locale')]) !!}">
                {{$controller->LL('title.login.forgot-password')}}
            </a>

        </div>
    </div>

</form>