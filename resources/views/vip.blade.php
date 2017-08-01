@extends('layouts.base')

@section('content')

    <div id="content" class="rounded-corners transparent_class content" style="">
        <div id="content-inner" style="text-align: left; line-height: 1em; margin: 15px; overflow: auto;">
            {!! Form::open(['url' => 'vip']) !!}
            <div style="float: left; padding: 20px;">
                <h1>
                    VIP Placement in Star Publication
                </h1>
                <p>
                    All stars registered through our website will be entered into our registry and published for the world to see (When it is released). As an add-on to any star order you can opt in for VIP placement within that publication. Your star will be featured in the VIP prologue along with other VIP customers, displayed before all the other regular registrations. In addition, your entry in the regular section will be highlighted in bold so that it stands out and everybody knows you paid for the extra visibility.
                </p>
                <p style="padding-left: 50px;">
                    <label class="radio" style="text-indent: 0; padding: 5px; font-size: 28px;">
                        <input type="radio" name="use_vip" value="1" {{ (($free_vip) ? "checked" : "") }} />
                        YES! I want to be registered as VIP [{{ ($free_vip) ? 'Free with Membership' : '+$5.00' }}]
                    </label>
                    <label class="radio" style="text-indent: 0; padding: 5px; font-size: 28px;">
                        <input type="radio" name="use_vip" value="0" {{ (($free_vip) ? "" : "checked") }} />
                        No thank you, just the standard [Included]
                    </label>
                </p>
            </div>
            <div align="center">
                {!! Form::submit('Continue to Registration', ['class' => 'super blue button']) !!}
            </div>
            {{ Form::close() }}
        </div>
    </div>

@endsection