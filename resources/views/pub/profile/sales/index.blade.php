@extends('pub.profile.layouts.profile')

@section('title', 'Sales History')

@section('page_content')
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <form action="{{ route('pub.profile.sales.store') }}" method="POST">
                    {{ csrf_field() }}
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Month</th>
                            <th>Sales Quantity</th>
                            <th>Sales Value ($)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sales as $key =>$sale)
                            {{--@php--}}
                                {{--$arrayKey = date('Y', strtotime("-$i month")).'.'.date('n', strtotime("-$i month"));--}}
                            {{--@endphp--}}
                            <tr>
                                <td>{{ $sale->formattedDate() }}</td>
                                <td class="form-group {{ $errors->has("sales.${key}.sales_total") ? 'has-error' : '' }}"
                                    style="width: 100px">
                                    <input type="hidden" name="sales[{{ $key }}][sales_year]" value="{{ $sale->sales_year }}">
                                    <input type="hidden" name="sales[{{ $key }}][sales_month]" value="{{ $sale->sales_month }}">
                                    <input
                                        type="text"
                                        name="sales[{{ $key }}][sales_total]"
                                        class="form-control"
                                        value="{{ old("sales.${key}.sales_total", $sale->sales_total) }}"
                                        {{--value={{ $sale->sales_total }}--}}
                                    >
                                    @if($errors->has("sales.${key}.sales_total"))
                                        <span class="help-block">
                                            <strong>{{ $errors->first("sales.${key}.sales_total") }}</strong>
                                        </span>
                                    @endif
                                </td>
                                <td class="form-group {{ $errors->has("sales.${key}.sales_value") ? 'has-error' : '' }}"
                                    style="width: 150px">
                                    <input
                                            type="number"
                                            name="sales[{{ $key }}][sales_value]"
                                            class="form-control"
                                            value="{{ old("sales.${key}.sales_value", $sale->sales_value) }}"
                                    >
                                    @if($errors->has("sales.${key}.sales_value"))
                                        <span class="help-block">
                                            <strong>{{ $errors->first("sales.${key}.sales_value") }}</strong>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-warning">Save</button>
                </form>
            </div>
        </div>
    </div>

@endsection

