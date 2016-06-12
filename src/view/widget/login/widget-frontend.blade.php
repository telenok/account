@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{!! route($controller->getRouteLogin()) !!}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div>
        <label>E-Mail Address</label>
        <div>
            <input type="text" name="{{$controller->getLoginUsername()}}" value="">
        </div>
    </div>

    <div>
        <label>Password</label>
        <div>
            <input type="password" name="password">
        </div>
    </div>


    <div>
        <div>
            <div>

                @foreach(['github', 'facebook', 'google', 'linkedin', 'twitter', 'bitbucket'] as $network)

                    @if (config('services.' . $network . '.enabled'))

                        <a href="{!! route('telenok.auth.redirect.social-network', ['name' => $network]) !!}" target="_blank">
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
                    <input type="checkbox" name="remember"> Remember Me
                </label>
            </div>
        </div>
    </div>

    <div>
        <div>
            <button type="submit">Login</button>

            <a href="{!! route('telenok.auth.password-restore', ['locale' => config('app.locale')]) !!}">
                Forgot Your Password?
            </a>

        </div>
    </div>

</form>