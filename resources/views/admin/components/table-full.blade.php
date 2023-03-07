<table id="{{ $id }}" class="table table-bordered table-striped dataTable" role="grid">
    <thead>
        <tr role="row">
            @foreach(explode('|', $header) as $key => $h)
                <th class="sorting" tabindex="{{ $key }}" rowspan="1" colspan="1">{{ $h }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>
</table>

@section('scripts-footer')
    <script>
		$('#{{ $id }}').DataTable({
			'paging'      : true,
			'lengthChange': false,
			'searching'   : true,
			'ordering'    : true,
			'info'        : true,
			'autoWidth'   : false,
            'responsive'  : true
		})
    </script>
@endsection