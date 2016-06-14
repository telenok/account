<div>
    <div>{{$controller->LL('header.reset')}}</div>
    <div>
        @if (session('status'))
            <div>
                {{ session('status') }}
            </div>
        @endif

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

        <form method="POST" action="{!! route($controller->getRouteReset()) !!}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div>
                <label>{{$controller->LL('title.reset.email')}}</label>
                <div>
                    <input type="email" name="email" value="{{ old('email') }}">
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