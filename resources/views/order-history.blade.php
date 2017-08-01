@extends('layouts.base')

@section('content')

    <div id="content" class="rounded-corners transparent_class content" style="">
        <div id="content-inner" style="text-align: left; line-height: 1em; margin: 15px; overflow: auto;">
            <div style="float: left; padding: 20px; padding-bottom: 0px; width: 94%;">
                <h1>
                    Order History
                </h1>

                @if (count($orders) > 0)
                    @foreach ($orders as $order)
                        @if ($order->package == 'digital')
                            <?php $package = "Digital Star Order" ?>
                        @elseif ($order->package == 'premium')
                            <?php $package = "Premium Star Order" ?>
                        @elseif ($order->package == 'ultimate')
                            <?php $package = "Ultimate Star Order" ?>
                        @elseif ($order->package == 'digital_membership')
                            <?php $package = "Digital Membership" ?>
                        @elseif ($order->package == 'premium_membership')
                            <?php $package = "Premium Membership" ?>
                        @elseif ($order->package == 'ultimate_membership')
                            <?php $package = "Ultimate Membership" ?>
                        @endif

                        <?php $magnitude = $order->getMagnitude() ?>

                        @if ($magnitude == "low")
                            <?php $magnitude = "Low" ?>
                        @endif
                        @if ($magnitude == "med")
                            <?php $magnitude = "Medium" ?>
                        @endif
                        @if ($magnitude == "High")
                            <?php $magnitude = "High" ?>
                        @endif
                        <div style="clear: right; float: right;"><a href="{{ url('/download-pdf/' . $order->uuid) }}" class="large blue button" style="margin: 2px;">Download</a></div>
                        <div style="float: right;"><a href="{{ url('/order-detail/' . $order->uuid) }}" class="large blue button" style="margin: 2px;">Details</a></div>
                        <div style="clear: left; float: left; width: 13%; margin-top: 9px;">{{ ($order->id + 10000) }}</div>
                        <div style="float: left; width: 23%; margin-top: 9px;">{{ date("m-d-Y h:i:s", strtotime($order->created_at)) }}</div>
                        <div style="float: left; width: 22%; margin-top: 9px;">{{ $package }}</div>
                        <div style="float: left; width: 19%; margin-top: 9px;">{{ ucfirst($magnitude) }} Magnitude</div>
                    @endforeach
                @else
                    You do not have any orders.
                @endif
            </div>
        </div>
    </div>

@endsection