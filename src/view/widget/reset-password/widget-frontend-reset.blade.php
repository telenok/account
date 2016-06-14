<div>
    <div>{{$controller->LL('header.finish')}}</div>
    <div>
        @if (count($errors) > 0)
            <div>
                {!! $controller->LL('error.reset.input') !!}<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{!! route('telenok.account.reset.finish') !!}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="token" value="{{ old('token') }}">

            <div>
                <label>{{$controller->LL('title.finish.email')}}</label>
                <div>
                    <input type="email" name="email" value="{{ old('email') }}">
                </div>
            </div>

            <div>
                <label>{{$controller->LL('title.finish.email')}}</label>
                <div>
                    <input type="password" name="password">
                </div>
            </div>

            <div>
                <label>{{$controller->LL('title.finish.email')}}</label>
                <div>
                    <input type="password" name="password_confirmation">
                </div>
            </div>

            <div>
                <div>
                    <button type="submit">
                        {{$controller->LL('btn.reset.link')}}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
