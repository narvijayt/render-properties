@extends('admin.layouts.dashboard')

@section('section_title')
    Edit User
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            @component('admin.components.box-default')
                @slot('title')
                    Edit {{ $user->first_name }} {{ $user->last_name }}
                @endslot

                <form action="{{ route('admin.users.update', $user) }}" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    @include('admin.users.partials.user-form')
                </form>

            @endcomponent
        </div>
    </div>
@endsection