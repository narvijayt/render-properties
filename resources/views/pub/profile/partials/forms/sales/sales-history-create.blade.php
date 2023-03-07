<h4>Last 12 Months Sales</h4>
<div class="form-group">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Month</th>
            <th>Total Sales</th>
        </tr>
        </thead>
        <tbody>
        @for($i = 1; $i <=12; $i++)
            <tr>
                <td>{{ date('F, Y', strtotime("-$i month")) }}</td>
                <td>
                    <input type="hidden"
                           name="sales[{{ $i }}][sales_year]"
                           value="{{ date('Y', strtotime("-$i month")) }}" />
                    <input type="hidden"
                           name="sales[{{ $i }}][sales_month]"
                           value="{{ date('n', strtotime("-$i month")) }}" />
                    <input type="number"
                           class="form-control input-sm"
                           name="sales[{{ $i }}][sales_total]"
                           value="{{ old("sales.$i.sales_total") }}">

                    @if ($errors->has("sales.$i.sales_total"))
                        <span class="help-block">
                                <strong>{{ $errors->first("sales.$i.sales_total") }}</strong>
                            </span>
                    @endif
                </td>
            </tr>
        @endfor
        </tbody>
    </table>
</div>