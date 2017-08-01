<div style="clear: left; float: right"><a href="{{ url('/order-overview/' . $payment_method->uuid) }}" class="large blue button">Select</a></div>
<div style="clear: left; width: 250px; float: left; padding: 20px;">
    <p style="text-indent: 0px; margin-bottom: 3px;">
        {{ $payment_method->cc_name }}
    </p>
    <p style="text-indent: 0px; margin-bottom: 3px;">
        {{ $payment_method->cc_type }} {{ $payment_method->getCreditCardMaskedAttribute() }}
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