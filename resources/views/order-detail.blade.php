@extends('layouts.base')

@section('content')

    <div id="content" class="rounded-corners transparent_class content" style="">
        <div id="content-inner" style="text-align: left; line-height: 1em; margin: 15px; overflow: auto;">
            <div style="float: left; padding: 20px; width: 94%;">
                <a href="{{ url('/download-pdf/' . $uuid) }}" class="super blue button" style="float: right; text-align: center; width: 44%; margin: 0px; margin-top: 10px;">Download PDF Star Package</a>
                <a href="{{ url('/view-pdf/' . $uuid) }}" class="super blue button" style="clear: right; float: right; text-align: center; width: 44%; margin: 0px; margin-top: 10px;">View PDF Star Package</a>
                <h1>
                    Order Details #<?=($order_id + 10000)?>
                </h1>
                <div align="center" style="clear: both;">
                    <div style="float: left; text-align: left; margin-left: 32px; margin-top: -50px; font-size: 1.3em; line-height: 25px; width: 40%;">
                        <div style="clear: left; float: left; width: 100%">Placed on {{  date("m-d-Y", strtotime($order_date)) }} at {{ date("h:i:s A", strtotime($order_date)) }}</div>
                    </div>
                </div>
                <p style="clear: both; margin-top: 50px;">
                <div style="float: right; margin-top: 5px;">${{ $fees['package'] }}</div>
                <h3><{{ $package }}</h3>
                </p>
                <p>
                <p style="margin-bottom: 3px;">
                    Zodiac: {{ $zodiac }}
                </p>
                <p style="margin-bottom: 3px;">
                    Dedication: {{ $dedication }}
                </p>
                @if (($use_date == 1))
                <p style="margin-bottom: 3px;">
                    {{ (($use_date == 1) ? "Dedication Date: " . $dedicationDate : '') }}
                </p>
                @endif
                <div style="float: right; margin-top: 0px;">+${{ $fees['magnitude'] }}</div>
                <p style="margin-bottom: 3px; margin-top: 0px;">
                    Magnitude: {{ ucwords($magnitude) }}
                </p>
                @if ($vip)
                <div style="float: right; margin-top: 0px;">+${{ $fees['vip'] }}</div>
                <p style="margin-bottom: 3px; margin-top: 0px;">
                    VIP Placement
                </p>
                @endif
                <p>
                <div style="float: right; text-align: right; margin-top: 3px; width: 75px;">${{ $fees['tax'] }}</div>
                <div style="float: right; margin-top: 3px;"><strong>SALES TAX:</strong> </div>
                </p>
                <div style="clear: both;">
                    <div style="float: right; text-align: right; margin-top: 3px; width: 75px;">${{ $fees['total'] }}</div>
                    <div style="float: right; margin-top: 3px;"><strong>TOTAL:</strong> </div>
                </div>
                </p>
                <h3 style="font-size: 1.5em;">Payment Details</h3>
                <div style="clear: left; width: 250px; float: left; padding: 20px;">
                    <p style="text-indent: 0px; margin-bottom: 3px;">
                        {{ $payment_method->cc_name }}
                    </p>
                    <p style="text-indent: 0px; margin-bottom: 3px;">
                        {{ $payment_method->cc_type }} {{ $payment_method->credit_card_masked }}
                    </p>
                    <p style="text-indent: 0px; margin-bottom: 3px;">
                        Expiration: {{ $payment_method->cc_exp_month }}/{{ $payment_method->cc_exp_year }}
                    </p>
                </div>
                <div style="width: 250px; float: left; padding: 20px;">
                    <p style="font-weight: bold; text-indent: 0px; margin-bottom: 3px;">
                        BILLING ADDRESS:
                    </p>
                    <p style="text-indent: 0px; margin-bottom: 3px;">
                        {{ $payment_method->cc_address_line1 }}
                    </p>
                    <p style="text-indent: 0px; margin-bottom: 3px;">
                        {{ $payment_method->cc_address_line2 }}
                    </p>
                    <p style="text-indent: 0px; margin-bottom: 3px;">
                        {{ $payment_method->cc_address_city }}, {{ $payment_method->cc_address_state }} {{ $payment_method->cc_address_zip }}
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection