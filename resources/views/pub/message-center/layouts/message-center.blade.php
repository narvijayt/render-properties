@extends('layouts.app')

@section('content')
    @component('pub.components.container')
        @component('pub.components.page-standard')
            @slot('page_header')
                <h2>@yield('title')</h2>
            @endslot

            @yield('page-content')

        @endcomponent {{-- page layout --}}
    @endcomponent {{-- container --}}
@endsection