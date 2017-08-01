@extends('layouts.base')

@section('content')

    <div id="content" class="rounded-corners transparent_class content" style="">
        <div id="content-inner" style="text-align: left; line-height: 1em; margin: 15px; overflow: auto;">
            <div style="float: left; padding: 20px; width: 94%;">
                <h1>
                    Order Overview
                </h1>
                <p>
                <div style="float: right; margin-top: 5px;">${{ $fees['package'] }}</div>
                <h3>{{ $packageTranslated }}</h3>
                </p>
                <p>
                <p style="margin-bottom: 3px;">
                    Zodiac: {{ $zodiac }}
                </p>
                <p style="margin-bottom: 3px;">
                    Dedication: {{ $dedication }}
                </p>
                @if (!empty($dedicationDate))
                <p style="margin-bottom: 3px;">
                    {{ "Dedication Date: " . $dedicationDate }}
                </p>
                @endif
                <div style="float: right; margin-top: 0px;">+${{ $fees['magnitude'] }}</div>
                <p style="margin-bottom: 3px; margin-top: 0px;">
                    Magnitude: {{ $magnitude }}
                </p>
                @if (!empty($vip))
                <div style="float: right; margin-top: 0px;">+${{ $fees['vip'] }}</div>
                <p style="margin-bottom: 3px; margin-top: 0px;">
                    VIP Placement
                </p>
                @endif
                <p>
                <div style="float: right; text-align: right; margin-top: 3px; width: 75px;">${{ $fees['tax'] }}</div>
                <div style="float: right; margin-top: 3px;"><strong>{{ (empty($state)) ? '*' : '' }}SALES TAX:</strong> </div>
                </p>
                <div style="clear: both;">
                    <div style="float: right; text-align: right; margin-top: 3px; width: 75px;">${{ $fees['total'] }}</div>
                    <div style="float: right; margin-top: 3px;"><strong>TOTAL:</strong> </div>
                </div>
                </p>
                <p style="clear: both; margin-top: 40px;">
                    @if (empty($state))
                    * Sales tax is only required if you are in Florida. It will be removed before the charge goes through if you are from another state. You will receive an e-mail with the final receipt after the order is processed.
                    @endif
                </p>
                @if (($fees['total'] * 100) == 0)
                <div id="submit_button" style="clear: both; float: right; text-align: right; margin-top: 3px; width: 200px;">
                    <form action="{{ url('/charge.php') }}" method="POST">
                        <input type="hidden" name="sub_total" value="{{ $fees['sub_total'] * 100 }}" />
                        <input type="hidden" name="tax" value="{{ $fees['tax'] * 100 }}" />
                        <input type="hidden" name="total" value="{{ $fees['total'] * 100 }}" />
                        <button type="submit" value="Pay Now" class="large blue button">
                            <span style="display: block; ">Claim Now</span>
                        </button>
                    </form>
                </div>
                @else
                    @if (empty($state))
                    <label class="checkbox" style="float: right; width: 300px; padding-top: 15px;">
                        <input type="checkbox" name="agree" id="agree"> You must read and agree to the website <a href="{{ url('/terms') }}" target="_blank">terms of services</a> before continuing
                    </label>
                    <div id="submit_button" style="clear: both; float: right; text-align: right; margin-top: 3px; width: 200px; display: none;">
                        <form action="{{ url('/pay') }}" method="POST">
                            <input type="hidden" name="sub_total" value="{{ $fees['sub_total'] * 100 }}" />
                            <input type="hidden" name="tax" value="{{  $fees['tax'] * 100 }}" />
                            <input type="hidden" name="total" value="{{ $fees['total'] * 100 }}" />
                            <script
                                    src="https://checkout.stripe.com/v2/checkout.js" class="stripe-button"
                                    data-key="{{ \Config::get('services.stripe.key') }}"
                                    data-amount="{{ $fees['total'] * 100 }}"
                                    data-name="{{ $package }}"
                                    data-billingAddress="true"
                                    data-description="Star Package Order (${{ $fees['total'] }})"
                                    data-label="Pay Now"
                            >
                            </script>
                        </form>
                    </div>
                    @else
                    <p style="text-indent: 0px; font-weight: bold; clear: both; margin-bottom: 3px;">
                        This is the final confirmation, clicking pay now will charge your currently selected credit card.
                    </p>
                    <label class="checkbox" style="float: right; width: 300px; padding-top: 15px;">
                        <input type="checkbox" name="agree" id="agree"> You must read and agree to the website <a href="{{ url('/terms') }}" target="_blank">terms of services</a> before continuing
                    </label>
                    <div id="submit_button" style="clear: both; float: right; text-align: right; margin-top: 3px; width: 200px; display: none;">
                        <form action="{{ url('/charge') }}" method="POST">
                            <input type="hidden" name="sub_total" value="{{  $fees['sub_total'] * 100 }}" />
                            <input type="hidden" name="tax" value="{{ $fees['tax'] * 100 }}" />
                            <input type="hidden" name="total" value="{{  $fees['total'] * 100 }}" />
                            <button type="submit" value="Pay Now" class="large blue button">
                                <span style="display: block; ">Pay Now</span>
                            </button>
                        </form>
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script type="text/javascript">

        $(document).ready(function() {
            $('#content').css({'height':(($('body').height())-220)+'px'});
            $('#content-inner').css({'height':(($('body').height())-220-30)+'px'});

            $(window).resize(function(){
                $('#content').css({'height':(($('body').height())-220)+'px'});
                $('#content-inner').css({'height':(($('body').height())-220-30)+'px'});
            });

            $("#content-inner").niceScroll();

            $("#agree").click(function() {
                var checked;
                checked = $("#agree").is(":checked");

                if (checked) {
                    $("#submit_button").show();
                } else {
                    $("#submit_button").hide();
                }
            });
        });

    </script>

@endsection