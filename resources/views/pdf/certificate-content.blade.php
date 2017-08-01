<style>
    .gertrud {
        font-family: "Gertrud";
    }
</style>
<div style="position: absolute; left:0; right: 0; top: 0; bottom: 0;">
    <div style="padding-top: 210; width: 100%;">
        <div class="gertrud" style="padding-top: 40; padding-left: 100; font-size: 1.5em; text-align: center; width: 75%;">
            Be it known to all that on this day of {{ date("m-d-Y", strtotime($createdAt)) }}
            the star designated in the scientifically reknowned {{ ((!empty($ppmxlId)) ? "PPMXL (USNO-B1.0)" : "SAO") }} Star Catalog as
        </div>
        <div style="padding-top: 5; padding-left: 100; font-size: 2.5em; text-align: center; width: 75%;">
            {{ ((!empty($ppmxlId)) ? str_replace("PPMXL ", "", $starName) : $starName) }}
        </div>
        <div style="padding-top: 15; padding-left: 100; font-size: 1.5em; text-align: center; width: 75%;">
            is hereby named {{ $prefix }}
        </div>
        <div style="padding-top: -7; padding-left: 100; line-height: 1em; font-size: 3.2em; text-align: center; width: 75%;">
            {{ ucwords($orderName) }}
        </div>
        <div style="padding-top: -15; padding-left: 100; font-size: 2.7em; text-align: center; width: 75%;">
            {{ ((!empty($createdAt) ? date("m-d-Y", strtotime($createdAt)) : '&nbsp;')) }}
        </div>
        <div style="padding-top: 15; padding-left: 110; font-size: 1.5em; text-align: center; width: 73%;">
            This star's astronomically verified position is:
        </div>
        <div style="padding-top: -8; padding-left: 110; font-size: 1.5em; line-height: 0.3em; text-align: center; width: 73%;">
            &nbsp;
        </div>
        <div style="padding-top: 15; padding-left: 110; font-size: 1.5em; text-align: center; width: 73%;">
            Right Ascension {{ $raConverted }} [{{ $ra }}]
        </div>
        <div style="padding-top: 0; padding-left: 110; font-size: 1.5em; text-align: center; width: 73%;">
            Declination {{ $decConverted }} [{{ $dec }}]
        </div>
        <div style="padding-top: -8; padding-left: 110; font-size: 1.5em; line-height: 0.3em; text-align: center; width: 73%;">
            &nbsp;
        </div>
        <div style="padding-top: 25; padding-left: 110; font-size: 1.5em; text-align: center; width: 73%;">
            Magnitude {{ $vmag }}
        </div>
    </div>
</div>