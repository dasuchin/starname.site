<div style="position: absolute; left:0; right: 0; top: 0; bottom: 0;">
    <div style="padding-top: 23; width: 100%;">
        <div style="text-align: center; font-size: 2em; line-height: 0.7em;">"{{ $orderName }}" (Mag {{ number_format($vmag, 1) }})</div>
        <div style="margin-top: 680; text-align: center; font-size: 1.2em; line-height: 0.6em;">{{ implode(" | ", $ids) }}</div>
        <div style="text-align: center; font-size: 1.3em;">RA: {{ $ra }} [{{ $raConverted }}] | DEC: {{ $dec }} [{{ $decConverted }}]</div></div>
</div>