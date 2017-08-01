@extends('layouts.base')

@section('content')

    <div id="content" class="rounded-corners transparent_class content" style="">
        <div id="content-inner" style="text-align: left; line-height: 1em; margin: 15px; overflow: auto;">
            {!! Form::open(['id' => 'zodiac-form', 'url' => 'zodiac']) !!}
            {!! Form::hidden('zodiac', '', ['id' => 'zodiac-hidden']) !!}
            <h1>
                Choose your Zodiac Sign:
            </h1>
            <p>
                We will try our best to match you in the star map correlating to your zodiac sign but can not guarantee something will always be available.
            </p>
            <a class="zodiac" data-zodiac="aries" style="background: url({{ asset('images/aries_256.png') }}); background-size: contain;" title="Aries"></a>
            <a class="zodiac" data-zodiac="taurus" style="background: url({{ asset('images/taurus_256.png') }}); background-size: contain;" title="Taurus"></a>
            <a class="zodiac" data-zodiac="gemini" style="background: url({{ asset('images/gemini_256.png') }}); background-size: contain;" title="Gemini"></a>
            <a class="zodiac" data-zodiac="cancer" style="background: url({{ asset('images/cancer_256.png') }}); background-size: contain;" title="Cancer"></a>
            <a class="zodiac" data-zodiac="leo" style="background: url({{ asset('images/leo_256.png') }}); background-size: contain;" title="Leo"></a>
            <a class="zodiac" data-zodiac="virgo" style="background: url({{ asset('images/virgo_256.png') }}); background-size: contain;" title="Virgo"></a>
            <a class="zodiac" data-zodiac="libra" style="background: url({{ asset('images/libra_256.png') }}); background-size: contain;" title="Libra"></a>
            <a class="zodiac" data-zodiac="scorpio" style="background: url({{ asset('images/scorpio_256.png') }}); background-size: contain;" title="Scorpio"></a>
            <a class="zodiac" data-zodiac="sagittarius" style="background: url({{ asset('images/sagittarius_256.png') }}); background-size: contain;" title="Sagittarius"></a>
            <a class="zodiac" data-zodiac="capricorn" style="background: url({{ asset('images/capricorn_256.png') }}); background-size: contain;" title="Capricorn"></a>
            <a class="zodiac" data-zodiac="aquarius" style="background: url({{ asset('images/aquarius_256.png') }}); background-size: contain;" title="Aquarius"></a>
            <a class="zodiac" data-zodiac="pisces" style="background: url({{ asset('images/pisces_256.png') }}); background-size: contain;" title="Pisces"></a>
            {{ Form::close() }}
        </div>
    </div>

@endsection

@section('js')

    <script type="text/javascript">
        $(document).ready(function() {
            $('.zodiac').click(function() {
                var zodiac = $(this).attr('data-zodiac');
                $('#zodiac-hidden').val(zodiac);
                $('#zodiac-form').submit();
            });
        });
    </script>

@endsection

@section('css')

    <style>
        .zodiac {
            cursor: pointer;
        }
    </style>

@endsection