@extends('layouts.base')

@section('content')

    <div id="content" class="rounded-corners transparent_class content" style="">
        <div id="content-inner" style="text-align: left; line-height: 1em; margin: 15px; overflow: auto;">
            {!! Form::open(['url' => '/login']) !!}
            <div style="padding: 20px;">
                <h1>
                    Login To Proceed
                </h1>
                <p>
                    You will need to have an account with us in order to complete the star ordering process. Click
                    <a href="{{ url('/password/reset') }}">here</a> if you have
                    <a href="{{ url('/password/reset') }}">forgotten your password</a>.
                </p>
                <p style="margin-bottom: 0px; text-align: center;">
                    <input style="min-width: 250px; height: 30px; font-size: 1em;" name="email" type="text" placeholder="E-mail Address" />
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </p>
                <p style="margin-bottom: 0px; text-align: center;">
                    <input style="min-width: 250px; height: 30px; font-size: 1em;" name="password" type="password" placeholder="Password" />
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </p>
                <p style="margin-bottom: 0px; text-align: center;">
                    <input type="submit" style="width: 250px; margin-top: 0px;" id="login" class="super blue button" value="Login" />
                    {{--<div class="checkbox" style="margin-left: auto; margin-right: auto; width: 20%;">--}}
                        {{--<label>--}}
                            {{--<input type="checkbox" name="remember"> Remember Me--}}
                        {{--</label>--}}
                    {{--</div>--}}
                </p>
                <p style="margin-bottom: 0px; padding: 5px; text-align: center;">
                    <a href="{{ url('/register') }}">Register a new account</a>
                </p>
                <p style="margin-bottom: 0px; padding: 5px; text-align: center;">
                    Login with a social provider
                </p>
                <p style="margin: 0px; padding: 0px; text-align: center;">
                    <a href="{{ url('/auth/google') }}" style="text-decoration: none;"><i class="fa fa-google fa-2x" style="display: block;"></i></a>
                </p>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection

@section('content2')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-sign-in"></i>Login
                                    </button>

                                    <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
