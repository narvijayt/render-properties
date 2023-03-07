@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('pub.profile.layouts.profile')

@section('title', 'Manage Matching Settings')

@section('meta')
    {{ meta('description', config('seo.description')) }}
@endsection


@section('page_content')

    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('pub.profile.settings.update') }}" method="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}

                <h3>Email Preferences</h3>

				<?php /** @var App/UserSetting $settings */ ?>
                <label class="control-label">Would you like to receive conversation notifications?</label>
                <div class="checkbox">
                    <label class="radio-inline">
                        <input
                                type="radio"
                                name="email_receive_conversation_messages"
                                value="1"
                                @if(old('email_receive_conversation_messages', $settings->email_receive_conversation_messages) == true) checked @endif
                        > Yes
                    </label>
                    <label class="radio-inline">
                        <input
                                type="radio"
                                name="email_receive_conversation_messages"
                                value="0"
                                @if(old('email_receive_conversation_messages', $settings->email_receive_conversation_messages) == false) checked @endif
                        > No
                    </label>
                </div>

                <label class="control-label">Would you like to receive match request notifications?</label>
                <div class="checkbox">
                    <label class="radio-inline">
                        <input
                                type="radio"
                                name="email_receive_match_requests"
                                value="1"
                                @if(old('email_receive_match_requests', $settings->email_receive_match_requests) == true) checked @endif
                        > Yes
                    </label>
                    <label class="radio-inline">
                        <input
                                type="radio"
                                name="email_receive_match_requests"
                                value="0"
                                @if(old('email_receive_match_requests', $settings->email_receive_match_requests) == false) checked @endif
                        > No
                    </label>
                </div>

                <label class="control-label">Would you like to receive match suggestions via email?</label>
                <div class="checkbox">
                    <label class="radio-inline">
                        <input
                                type="radio"
                                name="email_receive_match_suggestions"
                                value="1"
                                @if(old('email_receive_match_suggestions', $settings->email_receive_match_suggestions) == true) checked @endif
                        > Yes
                    </label>
                    <label class="radio-inline">
                        <input
                                type="radio"
                                name="email_receive_match_suggestions"
                                value="0"
                                @if(old('email_receive_match_suggestions', $settings->email_receive_match_suggestions) == false) checked @endif
                        > No
                    </label>
                </div>

                <label class="control-label">Would you like to receive review notifications via email?</label>
                <div class="checkbox">
                    <label class="radio-inline">
                        <input
                                type="radio"
                                name="email_receive_review_messages"
                                value="1"
                                @if(old('email_receive_review_messages', $settings->email_receive_review_messages) == true) checked @endif
                        > Yes
                    </label>
                    <label class="radio-inline">
                        <input
                                type="radio"
                                name="email_receive_review_messages"
                                value="0"
                                @if(old('email_receive_review_messages', $settings->email_receive_review_messages) == false) checked @endif
                        > No
                    </label>
                </div>

                <label class="control-label">Would you like to receive weekly updates via email?</label>
                <div class="checkbox">
                    <label class="radio-inline">
                        <input
                                type="radio"
                                name="email_receive_weekly_update_email"
                                value="1"
                                @if(old('email_receive_weekly_update_email', $settings->email_receive_weekly_update_email) == true) checked @endif
                        > Yes
                    </label>
                    <label class="radio-inline">
                        <input
                                type="radio"
                                name="email_receive_weekly_update_email"
                                value="0"
                                @if(old('email_receive_weekly_update_email', $settings->email_receive_weekly_update_email) == false) checked @endif
                        > No
                    </label>
                </div>

                <h3>Match Settings</h3>

                <div class="form-group{{ $errors->has('match_by_states') ? ' has-error' : '' }}">
                    <label for="state" class="control-label">States to receive match results from</label>
                    <div class="checkbox">
                        <label for="select-all-states-toggle">
                            <input type="checkbox" id="select-all-states-toggle"> Select All
                        </label>
                    </div>
                    <div class="row">
                        @foreach($states::all() as $abbr => $stateName)
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input
                                                type="checkbox"
                                                name="match_by_states[]"
                                                value="{{ $abbr }}"
                                                class="match_by_state_checkbox"
                                                @if(collect(old('match_by_states', $settings->match_by_states))->contains($abbr)) checked @endif
                                        > {{ $stateName }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('match_by_exp_min') ? 'has-error' : '' }}">

                            <label for="match_by_exp_min" class="control-label">Min Years of Experience</label>
                            <input
                                    type="number"
                                    class="form-control"
                                    placeholder="Min Years of Experience"
                                    name="match_by_exp_min"
                                    required
                                    value="{{ old('match_by_exp_min', $settings->match_by_exp_min) }}">
                            @if($errors->has('match_by_exp_min'))
                                <span class="help-block">
                                    <strong>
                                        {{ $errors->first('match_by_exp_min') }}
                                    </strong>
                                </span>
                            @endif

                        </div>
                    </div>

                    <div class="col-md-6">
                        {{-- City --}}
                        <div class="form-group{{ $errors->has('match_by_exp_max') ? ' has-error' : '' }}">

                            <label for="match_by_exp_max" class="control-label">Max Years of Experience</label>
                            <input
                                    id="match_by_exp_max"
                                    type="number"
                                    class="form-control"
                                    name="match_by_exp_max"
                                    placeholder="Max Years of Experience"
                                    required
                                    value="{{ old('match_by_exp_max', $settings->match_by_exp_max) }}"
                            >

                            @if ($errors->has('match_by_exp_max'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('match_by_exp_max') }}</strong>
                                </span>
                            @endif

                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('match_by_sales_total_min') ? 'has-error' : '' }}">

                            <label for="match_by_sales_total_min" class="control-label">Min Monthly Sales Total Average</label>
                            <input
                                    type="number"
                                    class="form-control"
                                    placeholder="Min Monthly Sales Total Average"
                                    name="match_by_sales_total_min"
                                    required
                                    value="{{ old('match_by_sales_total_min', $settings->match_by_sales_total_min) }}">
                            @if($errors->has('match_by_sales_total_min'))
                                <span class="help-block">
                                    <strong>
                                        {{ $errors->first('match_by_sales_total_min') }}
                                    </strong>
                                </span>
                            @endif

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('match_by_sales_total_max') ? 'has-error' : '' }}">

                            <label for="match_by_sales_total_max" class="control-label">Max Monthly Sales Total Average</label>
                            <input
                                    type="number"
                                    class="form-control"
                                    placeholder="MaxMonthly Sales Total Average"
                                    name="match_by_sales_total_max"
                                    required
                                    value="{{ old('match_by_sales_total_max', $settings->match_by_sales_total_max) }}">
                            @if($errors->has('match_by_sales_total_max'))
                                <span class="help-block">
                                    <strong>
                                        {{ $errors->first('match_by_sales_total_max') }}
                                    </strong>
                                </span>
                            @endif

                        </div>

                    </div>
                </div>

                <div class="form-group">

                    <button type="submit" class="btn btn-warning">
                        Save Settings
                    </button>

                </div>

            </form>
        </div>
    </div>

@endsection

@push('scripts-footer')
    <script>
        $('#select-all-states-toggle').on('change', function() {
            $('.match_by_state_checkbox').prop('checked', this.checked)
        })
    </script>
@endpush
