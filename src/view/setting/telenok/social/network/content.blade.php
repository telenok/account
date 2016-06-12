<div class="row">
    <div class="col-sm-6">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#socialite-github">
                        <i class="green ace-icon fa fa-home bigger-120"></i>
                        {{$controller->LL('services.github.title')}}
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#socialite-facebook">
                        <i class="green ace-icon fa fa-home bigger-120"></i>
                        {{$controller->LL('services.facebook.title')}}
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#socialite-google">
                        <i class="green ace-icon fa fa-home bigger-120"></i>
                        {{$controller->LL('services.google.title')}}
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#socialite-linkedin">
                        <i class="green ace-icon fa fa-home bigger-120"></i>
                        {{$controller->LL('services.linkedin.title')}}
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#socialite-twitter">
                        <i class="green ace-icon fa fa-home bigger-120"></i>
                        {{$controller->LL('services.twitter.title')}}
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#socialite-bitbucket">
                        <i class="green ace-icon fa fa-home bigger-120"></i>
                        {{$controller->LL('services.bitbucket.title')}}
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                @foreach(['github', 'facebook', 'google', 'linkedin', 'twitter', 'bitbucket'] as $key => $socnetwork)
                    <div id='socialite-{{$socnetwork}}' class="tab-pane fade @if ($key == 0) in active @endif">
                        <div class="form-group">
                            {!!  Form::label('value[services.'.$socnetwork.'.client_id]', $controller->LL('client_id'), ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                            <div class="col-sm-9">
                                {!!  Form::text('value[services.'.$socnetwork.'.client_id]',  $model->value->get('services.'.$socnetwork.'.client_id')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!  Form::label('value[services.'.$socnetwork.'.client_secret]', $controller->LL('client_secret'), ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                            <div class="col-sm-9">
                                {!!  Form::text('value[services.'.$socnetwork.'.client_secret]',  $model->value->get('services.'.$socnetwork.'.client_secret')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!  Form::label('value[services.'.$socnetwork.'.redirect]', $controller->LL('redirect'), ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                            <div class="col-sm-9">
                                {!!  Form::text('value[services.'.$socnetwork.'.redirect]',  $model->value->get('services.'.$socnetwork.'.redirect')) !!}
                                <span data-original-title="Field description" class="help-button" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Can be empty and then used CMS default redirect" title="">?</span>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('value[services.'.$socnetwork.'.enabled]', $controller->LL('enabled'), ['class' => 'col-sm-3 control-label no-padding-right']) !!}
                            <div class="col-sm-9">
                                {!! Form::checkbox('value[services.'.$socnetwork.'.enabled]', 1, $model->value->get('services.'.$socnetwork.'.enabled')) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>



