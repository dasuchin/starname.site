@extends('layouts.base')

@section('content')

    <div id="content" class="rounded-corners transparent_class content" style="">
        <div id="content-inner" style="text-align: left; line-height: 1em; margin: 15px; overflow: auto;">
            {!! Form::open(['url' => 'magnitude']) !!}
            <div style="float: left; padding: 20px;">
                <h1>
                    Select Desired Magnitude
                </h1>
                <p>
                    The magnitude of a star is how bright it appears to us from earth. The lower the magnitude rating the brighter the star, but for our purposes I am referring to low magnitude as the dimmest and high magnitude as the brightest.
                </p>
                <p style="padding-left: 50px;">
                    <label class="radio" style="text-indent: 0; padding: 5px; font-size: 28px;">
                        <input type="radio" name="magnitude" value="low" checked />
                        Low Magnitude (Dimmest) [Included]
                    </label>
                    <label class="radio" style="text-indent: 0; padding: 5px; font-size: 28px;">
                        <input type="radio" name="magnitude" value="med" />
                        Medium Magnitude (Average) [{{ ($mediumFree) ? 'Free with Membership' : '+$10.00 *free with qualifying membership' }}]
                    </label>
                    <label class="radio" style="text-indent: 0; padding: 5px; font-size: 28px;">
                        <input type="radio" name="magnitude" value="high" />
                        High Magnitude (Brightest) [{{ ($highFree) ? 'Free with Membership' : '+$20.00 *free with qualifying membership' }}]
                    </label>
                </p>
                <p style="font-size: 0.7em; line-height: 1em;">
                    DISCLAIMER: You are never guaranteed an exact magnitude, we simply assign you a random one in the range that you order. Low magnitude is the default range and is free. Stars chosen for this magnitude level are generally magnitude 9.0 - 20+ although the uncategorized and negative magnitude stars are also included in this group. If you chose low magnitude you are taking the gamble that you might get a very poor magnitude star, if you want to have a better class of star we recommend you go with the upper options. You will most likely not be able to see a low magnitude star purchased without expensive telescope hardware. Medium Magnitude is 8.0 - 8.9, the range is much smaller and you are guaranteed a star of at least magnitude 8.9. High Magnitude guarantees stars between 0.0 and 7.9, in practice you'll usually end up with a star of magnitude 6 or 7 but you can hit a stroke of luck and land a 0  - 5 star. Refunds are not given based upon the magnitude recieved (unless it's wildly outside of these advertised ranges, excluding negative or unknown magnitude stars which can and will happen if you order the default low magnitude range), you get what you are assigned so place your order with that in mind. Due to the nature of changing conditions of sky, seasons, pollution, etc there is no guarantee you'll be able to see a purchased star without a telescope (and even then depending on conditions it might still be extremely difficult). However, ordering the higher magnitude stars will of course increase your odds and using a service like Google Sky or Planetarium software will allow you to zero in on the exact coordinates regardless of visibility.
                </p>
                <p>
                    By clicking the continue button you agree that you have read the disclaimer above, understand and agree to it's terms. Refunds are not given for misunderstandings in regards to magnitude of your assigned star.
                </p>
            </div>
            <div align="center">
                {!! Form::submit('Continue to VIP Option', ['class' => 'super blue button']) !!}
            </div>
            {{ Form::close() }}
        </div>
    </div>

@endsection