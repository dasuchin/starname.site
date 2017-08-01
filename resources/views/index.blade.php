@extends('layouts.base')

@section('content')
    <div id="content" class="rounded-corners transparent_class content" style="">
        <div id="content-inner" style="text-align: left; line-height: 1em; margin: 15px; overflow: auto;">
            <div align="center"><h2>DISCLAIMER: Please read this before proceeding</h2></div>
            <p style="font-size: 0.9em;">
                There are many websites out there claiming to sell you the ability to name a star after a loved one and
                many of them are not quite so forthcoming about what is really going on behind the scenes. We strive to
                educate people and provide them with all the facts.
            </p>
            <p style="font-size: 0.9em;">
                None of these websites have the authority to officially name any of the stars in the heavens, including
                us. The IAU (International Astronomical Union) is the only authority on stars and they track the vast
                majority of stars with numbers / designations rather than actual names.
            </p>
            <p style="font-size: 0.9em;">
                That said, what we provide is a real service and is intended to be a specialty gift that is unique and
                shows that you actually put some thought into it. When you purchase a claim on a star from our website
                you are being provided with real information for a legitimate star in the sky, taken from our massive
                database of celestial objects. This database has been painstakingly crafted using multiple official
                stellar databases. We have currently in our primary star database roughly 15 million celestial objects
                and have at our disposal a backup repository with 900+ million objects that we can pull in at a moments
                notice. We have no shortage of stars available and will not assign any two people the same star, your
                claim will be absolutely unique. Rest assured the coordinates that you receive from us will be authentic
                and you'll be able to look your star up either online or in planetarium software. On a clear night you
                might even be able to spot it through a telescope or binoculars!
            </p>
            <p style="font-size: 0.9em;">
                You are purchasing a permanent place in our own official star registry, from which a book will be
                created and registered with the U.S. Copyright Office. In addition you will receive various "goodies"
                that you can show off and frame / hang on your wall for everybody to see. You will be able to return to
                this website at any time in the future and re-download your material if you happen to lose it.
            </p>
            <p style="font-size: 0.9em;">
                Now, if after reading all of the facts you are still interested in this service please proceed to claim
                a star and you'll be one step closer to putting that smile on your loved ones face as they unwrap your
                unique gift!
            </p>
            <p style="font-weight: bold; font-size: 1.2em; line-height: 1.0em;">
                Refunds are NOT given under any circumstance due to the nature of the digital products involved, once
                you have purchased it we have no way to take the product back, you will be given immediate access to
                download your materials as soon as the payment clears.
            </p>
            <div align="center"><a href="{{ url('/packages') }}" class="super blue button">Claim Your Own Personal Star Now!</a></div>
        </div>
    </div>
@endsection