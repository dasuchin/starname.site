@extends('layouts.base')

@section('content')

    <div id="content" class="rounded-corners transparent_class content" style="">
        <div id="content-inner" style="text-align: left; line-height: 1em; margin: 15px; overflow: auto;">
            {!! Form::open(['url' => 'packages']) !!}
            <div>
                <div style="float: right">
                    <div style="padding: 0; margin-top: 15px; text-align: center;">Starting at only $14.95!</div>
                    {!! Form::submit('Choose Digital Package', [
                        'name' => 'package-submit',
                        'class' => 'super blue button'
                    ]) !!}
                </div>
                <h1>Digital Star Package</h1>
                <p>
                    This package is the most affordable and all your resources can be downloaded directly to your home
                    computer and either printed out yourself or taken to a print shop such as Kinkos to be printed. As
                    with all of our digital products you will be able to log in to your account at any time and
                    re-download everything if you lose it. This is the best package for those budget-minded individuals!
                </p>

                Package contents:<br />
                <ul style="margin-top: 10px;" class="circle">
                    <li>Handsome certificate to signify your claim on the star you named, this proudly displays the name
                        you chose as well as any date that you may optionally provide</li>
                    <li>Detailed star map containing the star you've laid claim to</li>
                    <li>You will be provided with exact coordinates that you can use to locate your star in any major
                        planetarium software / google sky</li>
                    <li>Your star and the chosen name will be recorded into our "Stellar Entities Identification Catalog"
                        database where you'll be recorded for all of time</li>
                    <li>A book will be published containing all of the stars registered through our website and you'll
                        be given access at a later date to a digital copy of this publication when it is available to
                        the public</li>
                </ul>
            </div>

            <div style="clear: both; margin-top: 50px;">
                <div style="float: right">
                    <div style="padding: 0; margin-top: 15px; text-align: center;">Only $5.00 / Month</div>
                    {!! Form::submit('Choose Digital Membership', [
                        'name' => 'package-submit',
                        'class' => 'super blue button'
                    ]) !!}
                </div>
                <h1>Digital Membership</h1>
                <p>
                    When you become a member, you get all the same goodies that you get when you buy a Digital Star
                    Package only you are able to claim a new star once every month for the entire year. All membership
                    plans must be paid in advance for the entire year.
                </p>

                Membership Details:<br />
                <ul style="margin-top: 10px;" class="circle">
                    <li>Great value, claim one star per month for the entire year, that is 12 stars! A fantastic deal</li>
                    <li>All stars covered under this membership are of low magnitude with no addons, addons are the
                        normal price</li>
                    <li>The same great contents that come with all digital orders</li>
                    <li>Your stars and the chosen names will be recorded into our
                        "Stellar Entities Identification Catalog" database where you'll be recorded for all of time</li>
                    <li>A book will be published containing all of the stars registered through our website and you'll
                        be given access at a later date to a digital copy of this publication when it is available to
                        the public</li>
                </ul>
            </div>

            <div style="clear: both; margin-top: 50px;">
                <div style="float: right">
                    <div style="padding: 0; margin-top: 15px; text-align: center;">Only $7.00 / Month</div>
                    {!! Form::submit('Choose Premium Membership', [
                        'name' => 'package-submit',
                        'class' => 'super blue button'
                    ]) !!}
                </div>
                <h1>Premium Membership</h1>
                <p>
                    When you become a member, you get all the same goodies that you get when you buy a Digital Star
                    Package only you are able to claim new stars every month for the entire year. All membership plans
                    must be paid in advance for the entire year.
                </p>

                Membership Details:<br />
                <ul style="margin-top: 10px;" class="circle">
                    <li>Great value, claim 3 stars per month for the entire year, that is 36 stars! A fantastic deal</li>
                    <li>You can claim both low and medium magnitude stars with this membership. Additional addons are
                        the normal price</li>
                    <li>The same great contents that come with all digital orders</li>
                    <li>Your stars and the chosen names will be recorded into our
                        "Stellar Entities Identification Catalog" database where you'll be recorded for all of time</li>
                    <li>A book will be published containing all of the stars registered through our website and you'll
                        be given access at a later date to a digital copy of this publication when it is available to
                        the public</li>
                </ul>
            </div>

            <div style="clear: both; margin-top: 50px;">
                <div style="float: right">
                    <div style="padding: 0; margin-top: 15px; text-align: center;">Only $10.00 / Month</div>
                    {!! Form::submit('Choose Ultimate Membership', [
                        'name' => 'package-submit',
                        'class' => 'super blue button'
                    ]) !!}
                </div>
                <h1>Ultimate Membership</h1>
                <p>
                    When you become a member, you get all the same goodies that you get when you buy a Digital Star
                    Package only you are able to claim new stars every month for the entire year. All membership plans
                    must be paid in advance for the entire year.
                </p>

                Membership Details:<br />
                <ul style="margin-top: 10px;" class="circle">
                    <li>Best value, claim as many stars as you like all year! (only 5 per month can be high magnitude)</li>
                    <li>You can claim any magnitude of stars with this membership. All orders automatically qualify for
                        VIP.</li>
                    <li>The same great contents that come with all digital orders</li>
                    <li>Your stars and the chosen names will be recorded into our
                        "Stellar Entities Identification Catalog" database where you'll be recorded for all of time</li>
                    <li>A book will be published containing all of the stars registered through our website and you'll
                        be given access at a later date to a digital copy of this publication when it is available to
                        the public</li>
                </ul>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection