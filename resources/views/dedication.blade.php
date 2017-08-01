@extends('layouts.base')

@section('content')

    <div id="content" class="rounded-corners transparent_class content" style="">
        <div id="content-inner" style="text-align: left; line-height: 1em; margin: 15px; overflow: auto;">
            {!! Form::open(['id' => 'dedication-form', 'url' => 'dedication']) !!}
            <div style="width: 45%; float: left; padding: 20px;">
                <h1>
                    Dedicate your star:
                </h1>
                <p style="padding-left: 50px;">
                    <label class="radio" style="text-indent: 0; font-size: 28px;">
                        <input type="radio" name="prefix" id="prefix1" value="1" checked />
                        In Honor Of ___
                    </label>
                    <label class="radio" style="text-indent: 0; font-size: 28px;">
                        <input type="radio" name="prefix" id="prefix2" value="2" />
                        In Memory Of ___
                    </label>
                    <label class="radio" style="text-indent: 0; font-size: 28px;">
                        <input type="radio" name="prefix" id="prefix3" value="3" />
                        With Love To ___
                    </label>
                    <label class="radio" style="text-indent: 0; font-size: 28px;">
                        <input type="radio" name="prefix" id="prefix4" value="0" />
                        No thanks, just the name
                    </label>
                </p>
                <p>
                    <input style="min-width: 250px; height: 30px; font-size: 1em;" name="name" type="text" placeholder="Type a name here..." />
                </p>
            </div>
            <div style="float: left; padding: 20px;">
                <h1>
                    Dedication Date:
                </h1>
                <p style="padding-left: 50px;">
                    <label class="radio" style="text-indent: 0; font-size: 28px;">
                        <input type="radio" name="use_date" value="1" />
                        Use dedication date
                    </label>
                    <label class="radio" style="text-indent: 0; font-size: 28px;">
                        <input type="radio" name="use_date" value="0" checked />
                        No thanks, just the name
                    </label>
                </p>
                <p>
                    <input class="datepicker" style="min-width: 250px; height: 30px; font-size: 1em;" name="date" type="text" />
                </p>
            </div>
            <div align="center">
                {!! Form::submit('Continue to Magnitude Selection', ['class' => 'super blue button']) !!}
            </div>
            {{ Form::close() }}
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
            $(".datepicker").datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#dedication-form').submit(function() {
                var prefix, name, use_date, date;

                prefix = $("input[name=prefix]:checked").val();
                name = $("input[name=name]").val();
                use_date = $("input[name=use_date]:checked").val();
                date = $("input[name=date]").val();

                if (use_date == 1 && date == '') {
                    alert("You can not leave dedication date empty when you select to use it!");
                    return false;
                } else if (name.length > 34) {
                    alert("The maximum name allowed is 34 characters, please shorten it.");
                    return false;
                } else if (name.length < 1) {
                    alert("You must provide a name for the dedication.");
                    return false;
                }
            });

        });
    </script>

@endsection