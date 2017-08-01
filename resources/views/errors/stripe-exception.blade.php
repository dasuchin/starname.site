@extends('layouts.base')

@section('content')

    <div id="content" class="rounded-corners transparent_class content" style="">
        <div id="content-inner" style="text-align: left; line-height: 1em; margin: 15px; overflow: auto;">
            <div style="float: left; padding: 20px; padding-bottom: 0px; width: 94%;">
                <h1>
                    Payment Processor Error
                </h1>
                <p>
                    {!! $error !!}
                </p>
                <p>
                    We are very sorry you have encountered a problem. Please contact us at <a href="mailto:{{ \Config::get('app.support_email') }}">{{ \Config::get('app.support_email') }}</a> for further support.
                </p>
            </div>
        </div>
    </div>

@endsection