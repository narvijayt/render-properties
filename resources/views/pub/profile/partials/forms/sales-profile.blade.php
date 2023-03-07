{{ csrf_field() }}

<div class="form-group{{ $errors->has('years_exp') ? ' has-error' : '' }}">
    <label for="years_exp" class="control-label">Years of Experience</label>

    <input
        id="years_exp"
        type="number"
        class="form-control"
        name="years_exp"
        value="{{ old('years_exp', (isset($profile->years_exp) ? $profile->years_exp : '')) }}"
        required>

    @if ($errors->has('years_exp'))
        <span class="help-block">
            <strong>{{ $errors->first('years_exp') }}</strong>
        </span>
    @endif
</div>

@if (isset($include_sales_history) && $include_sales_history === true)
    @include('pub.profile.partials.forms.sales.sales-history-create')
@endif

<div class="form-group">
    <button type="submit" class="btn btn-primary">
        Submit
    </button>
</div>

