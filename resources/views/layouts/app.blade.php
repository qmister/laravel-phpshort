@extends('layouts.wrapper')

@section('body')
    <body class="d-flex flex-column">
        @include('shared.header')

        <div class="d-flex flex-column flex-fill @auth content @endauth">
            @yield('content')

            @include('shared.footer')
            {!! config('settings.tracking_code') !!}
        </div>
    </body>
@endsection