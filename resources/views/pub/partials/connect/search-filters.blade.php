@inject('states', 'App\Http\Utilities\Geo\USStates')
<div class="search-filters">
	<h4>Search Filters</h4>
	@if(Request::segment(1) == 'search-realtor-profiles')
		<form action="{{ route('pub.connect.realtorProfiles') }}" role="form" id="search-form">
		@elseif(Request::segment(1) == 'search-lender-profiles')
			<form action="{{ route('pub.connect.lenderProfiles') }}" role="form" id="search-form">
				@elseif(Request::segment(1) == 'search-vendor-profiles')
					<form  action="{{ route('pub.connect.vendorProfiles') }}" role="form" id="search-form">
	@else
		<form action="{{ route('pub.connect.index') }}" role="form" id="search-form">
	@endif
	<div class="row">
		<div class="@if(Request::segment(1) == 'search-vendor-profiles') col-md-4 @else col-md-3  @endif search-results__group">
			<strong>Search By</strong>
				<div class="radio">
					<label class="radio-inline">
						<input
						type="radio"
						class="search-type-input"
						name="search_type"
						id="searchLocation"
						value="radius"
						{{  old('search_type', $params->search_type) === 'radius' ? ' checked' : '' }}
						> Radius
					</label>
					<label class="radio-inline">
						<input
						type="radio"
						class="search-type-input"
						name="search_type"
						id="searchState"
						value="state"
						{{ old('search_type', $params->search_type) === 'state' ? ' checked' : '' }}
						> State
					</label>
					<label class="radio-inline">
						<input
						type="radio"
						class="search-type-input"
						name="search_type"
						id="searchName"
						value="name"
						{{  old('search_type', $params->search_type) === 'name' ? ' checked' : '' }}
						> Name
					</label>
					@if(Request::segment(1) == 'search-vendor-profiles')
					<label class="radio-inline">
						<input
						type="radio"
						class="search-type-input"
						name="search_type"
						id="searchCategory"
						value="category"
						{{  old('search_type', $params->search_type) === 'category' ? ' checked' : '' }}
						> Category
					</label>
					@endif
				</div>
		</div>
		<div id="locationSearchInputs" class="col-md-6 {{ old('search_type', $params->search_type) === 'radius' ? '' : 'hide' }}">
			<div class="row">
				<div class="col-md-4 form-group{{ $errors->has('radius') ? ' has-error' : '' }}">
					<strong>Radius</strong>
					<select name="radius" class="form-control">
						@foreach([10, 25, 50, 100] as $distance)
							<option value="{{ $distance }}" @if($params->radius == $distance) selected @endif>{{ $distance }}</option>
						@endforeach
					</select>
					@if ($errors->has('radius'))
						<span class="help-block">
						<strong>{{ $errors->first('radius') }}</strong>
						</span>
					@endif
				</div>
				<div class="col-md-8 search_results__group form-group{{ $errors->has('location') ? ' has-error' : '' }}">
					<strong>Location</strong>
					<input
					type="text"
					name="location"
					value="{{ old('location', $params->location) }}"
					class="form-control">
					@if ($errors->has('location'))
						<span class="help-block">
						<strong>{{ $errors->first('location') }}</strong>
						</span>
					@endif
				</div>
			</div>
		</div>
		<div id="stateSearchInput" class="col-md-4 {{ old('search_type', $params->search_type) === 'state' ? '' : 'hide' }}">
			<div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
				<strong>Select State</strong>
				<select class="form-control" name="state">
					<option value="">Choose a state</option>
						@foreach($states::all() as $abbr => $stateName)
							<option value="{{ $abbr }}" {{ collect(old('state', $params->state))->contains($abbr) ? 'selected' : '' }}>{{ $stateName }}</option>
						@endforeach
				</select>
				@if ($errors->has('state'))
					<span class="help-block">
					<strong>{{ $errors->first('state') }}</strong>
					</span>
				@endif
			</div>
		</div>
		<div id="nameSearchInput" class="col-md-4 {{ old('search_type', $params->search_type) === 'name' ? '' : 'hide' }}">
			<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
				<strong>Search By Name</strong>
				<input type="search" name="name" placeholder="Enter Name" class="form-control" @if(isset( $_GET['name'])) value="{{ old('name', $params->name) }}"  @endif/>
			</div>
		</div>
		@if(Request::segment(1) == 'search-vendor-profiles')
		<div id="categorySearchInput" class="col-md-4 {{old('search_type', $params->search_type) === 'category' ? '' : 'hide' }}">
			<div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
				<strong>Search By Category</strong>
				<select name="category" class="form-control{{ $errors->has('category') ? ' has-error' : '' }}">
				<option value="">Choose a category</option>
					@foreach($allcat as $categoryVendor)
						<option value="{{$categoryVendor->id}}" {{ collect(old('state', $params->category))->contains($categoryVendor->id) ? 'selected' : '' }}>{{$categoryVendor->name}}</option>
					@endforeach
				</select>
			@if ($errors->has('category'))
				<span class="help-block">
					<strong>{{ $errors->first('category') }}</strong>
				</span>
			@endif
			</div>
		</div>
		@endif
	</div>
	<div class="row">
		<div class="col-md-12">
		<button type="submit" class="btn btn-warning">Apply Filters</button>
		</div>
		</div>
</form>
<strong>Results:</strong> {{$users->total()}}
</div>
@push('scripts-footer')
<script>
	$('document').ready(function() {
		$locationInputs = $('#locationSearchInputs')
		$stateInputs = $('#stateSearchInput')
		$searchTypeInput = $('.search-type-input');
		$nameInputs = $('#nameSearchInput');
		$categoryInput = $('#categorySearchInput');
		var determineSearchType = function() {
		return $searchTypeInput.filter(':checked').val()
	}
	determineSearchType()
	$searchTypeInput.on('change', function() {
	var type = determineSearchType();
     if (type === 'radius') {
			$locationInputs.removeClass('hide');
			$stateInputs.addClass('hide');
			$nameInputs.addClass('hide');
			$categoryInput.addClass('hide');
		} else if (type === 'state') {
			$locationInputs.addClass('hide');
			$stateInputs.removeClass('hide');
			$nameInputs.addClass('hide');
			$categoryInput.addClass('hide');
		} else if (type === 'name') {
			$locationInputs.addClass('hide');
			$nameInputs.removeClass('hide');
			$stateInputs.addClass('hide');
			$categoryInput.addClass('hide');
		} else if (type ==='category') {
			$locationInputs.addClass('hide');
			$nameInputs.addClass('hide');
			$stateInputs.addClass('hide');
			$categoryInput.removeClass('hide');
		}
	})
	})
</script>
@endpush