@extends('layouts.base')

<!-- Main Content -->
@section('content')
    <div id="content" class="rounded-corners transparent_class content" style="">
        <div id="content-inner" style="text-align: left; line-height: 1em; margin: 15px; overflow: auto;">
            <div style="padding: 20px;">
                <h1>
                    Reset Password
                </h1>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="form-inline" role="form" method="POST" action="{{ url('/password/email') }}">
                    {!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">E-Mail Address </label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="super blue button" style="margin-left: 0px; margin-top: 5px;">
                            <i class="fa fa-btn fa-envelope"></i> Send Password Reset Link
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
