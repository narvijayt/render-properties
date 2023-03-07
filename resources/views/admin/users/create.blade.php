@extends('admin.layouts.dashboard')
@section('section_title')
    Create New User
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            @component('admin.components.box-default')
                @slot('title')
                    New user
                @endslot
                <form action="{{ route('admin.users.store') }}" method="post">
                    @include('admin.users.partials.user-form', ['include_pass' => true])
                </form>
            @endcomponent
        </div>
    </div>
@endsection