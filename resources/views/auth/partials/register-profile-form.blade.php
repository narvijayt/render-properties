{{ csrf_field() }}

<div class="form-group{{ $errors->has('years_exp') ? ' has-error' : '' }}">
    <label for="years_exp" class="col-md-4 control-label">Years of Experience</label>

    <div class="col-md-6">
        <input id="years_exp" type="number" class="form-control" name="years_exp" value="{{ old('years_exp') }}" required>

        @if ($errors->has('years_exp'))
            <span class="help-block">
                <strong>{{ $errors->first('years_exp') }}</strong>
            </span>
        @endif
    </div>
</div>

<h4 class="text-center">Last 12 Months Sales</h4>
<div class="form-group">
    <div class="col-md-12">
        @for($i = 1; $i <=12; $i++)
        <div class="row form-group{{ $errors->has("sales.$i.sales_total") ? ' has-error' : '' }}">
            <input type="hidden"
                   name="sales[{{ $i }}][sales_year]"
                   value="{{ date('Y', strtotime("-$i month")) }}" />
            <input type="hidden"
                   name="sales[{{ $i }}][sales_month]"
                   value="{{ date('n', strtotime("-$i month")) }}" />
            <label class="control-label col-md-4">{{ date('F, Y', strtotime("-$i month")) }}</label>
            <div class="col-md-6">
                <input type="number"
                       class="form-control"
                       name="sales[{{ $i }}][sales_total]"
                       value="{{ old("sales.$i.sales_total") }}">

                @if ($errors->has("sales.$i.sales_total"))
                    <span class="help-block">
                        <strong>{{ $errors->first("sales.$i.sales_total") }}</strong>
                    </span>
                @endif

            </div>
        </div>
        @endfor
    </div>
</div>

<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        <button type="submit" class="btn btn-primary">
            Submit
        </button>
    </div>
</div>