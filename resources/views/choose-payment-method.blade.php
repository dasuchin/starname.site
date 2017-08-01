@extends('layouts.base')

@section('content')

    <div id="content" class="rounded-corners transparent_class content" style="">
        <div id="content-inner" style="text-align: left; line-height: 1em; margin: 15px; overflow: auto;">
            <div style="float: left; padding: 20px; padding-bottom: 0px; width: 94%;">
                <h1>
                    Payment Method
                </h1>
                <p>
                    We have found payment previous payment methods attached to your account, would you like to use one of these to pay for your order today?
                </p>
            </div>
            @foreach ($payment_methods as $payment_method)
                @include('partials.payment-method', ['payment_method' => $payment_method])
            @endforeach
            <div align="center" style="clear: both;"><a href="{{ url('/order-overview/new') }}" class="super blue button">No, I want to use a new credit card</a></div>
        </div>
    </div>

@endsection