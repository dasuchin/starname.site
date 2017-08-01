@extends('layouts.base')

@section('content')

    <div id="content" class="rounded-corners transparent_class content" style="">
        <div id="content-inner" style="text-align: left; line-height: 1em; margin: 15px; overflow: auto;">
            <div style="float: left; padding: 20px; width: 94%;">
                <h1>
                    Manage Memberships
                </h1>
                @if ($subscriptions and $subscriptions->count() > 0)
                    @foreach ($subscriptions as $subscription)
                        @include('partials.subscription', ['subscription' => $subscription])
                    @endforeach
                @else
                <p>
                    You do not have any active memberships
                </p>
                @endif
            </div>
        </div>
    </div>

@endsection