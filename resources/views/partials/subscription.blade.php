<p style="margin: 0px; margin-top: 20px;">
    Type: {{ $subscription['plan']['name'] }}
</p>
<p style="margin: 0px; margin-top: 3px;">
    Status: {{ ($subscription['cancel_date'] ? "Cancelled" : "Active") }}
</p>
<p style="margin: 0px; margin-top: 3px;">
    ${{ number_format($subscription['plan']['amount'] / 100, 2) }} Recurring Every Month
</p>
<p style="margin: 0px; margin-top: 3px;">
    Membership valid until {{ $subscription['end'] }}
</p>
@if (!$subscription['cancel_date'])
    <p>
        <a href="{{ url('/cancel-subscription/' . $subscription['uuid']) }}" class="large blue button" style="text-indent: 0px; text-align: center; margin: 2px;">Cancel Membership</a>
    </p>
@endif