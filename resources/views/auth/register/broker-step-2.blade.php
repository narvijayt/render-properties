@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Realtor Profile</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('realtor-step-2-process') }}">

                            @include('auth.partials.register-profile-form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
