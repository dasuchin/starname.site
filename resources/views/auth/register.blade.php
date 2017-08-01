@extends('layouts.base')

@section('content')

    <div id="content" class="rounded-corners transparent_class content" style="">
        <div id="content-inner" style="text-align: left; line-height: 1em; margin: 15px; overflow: auto;">
            {!! Form::open(['method' => 'POST', 'url' => '/register']) !!}
            <div style="left; padding: 20px;">
                <h1>
                    Or Register
                </h1>
                <p>
                    If you do not have an account, you can create one below
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
                    <input style="min-width: 250px; height: 30px; font-size: 1em;" name="password_confirmation" type="password" placeholder="Re-enter Password" />
                </p>
                <p style="margin-bottom: 0px; text-align: center;">
                    <input type="submit" style="width: 250px; margin-top: 0px;" id="register" class="super blue button" value="Register" />
                </p>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection
