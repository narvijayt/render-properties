@extends('pub.profile.layouts.profile')

@section('title', 'Create Sales History')

@section('page_content')
    <div class="row">
        <div class="col-md-8">

            <form action="{{ route('pub.profile.realtor-profile.store') }}" method="POST">
                @include('pub.profile.partials.forms.sales-profile', ['include_sales_history' => true])
            </form>

        </div>
    </div>

@endsection