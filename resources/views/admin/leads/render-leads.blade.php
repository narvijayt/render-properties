<!-- Loader -->
<div class="loader c-loader" id="loader-2">
    <span></span>
    <span></span>
    <span></span>
</div>

<!-- Records Summary Section -->
<div class="admin_lead_table mb-4">
    <div class="row">
        <div class="col-md-6">
            <div class="card border-info mb-3">
                <div class="card-header bg-info text-white p-2">
                    Total Records: {{ $total_records ?? 'N/A' }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-warning mb-3">
                <div class="card-header bg-warning text-dark">
                    Filtered Records: {{ $total_filtered_records ?? 'N/A' }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="admin_lead_table">
    <table id="realor_table" class="table table-bordered table-striped ">
        <thead>
            <tr>
                <th>Sr No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>City</th>
                <th>State</th>
                @if ($filter_type == "property")
                    <th>Sell / Buy</th>
                @endif
                <th>Received On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        
            @if(isset($leads) && $leads->isNotEmpty())
                @php $currentIndex = $startIndex; @endphp
                @foreach($leads as $lead)
                    @php  
                        $phoneNumber = $filter_type == "property" ? $lead->phoneNumber : $lead->phone_number;
                        $routeType = $filter_type == 'property' ? 'property' : 'refinance';
                        $viewLeadHref = route("admin.leads.$routeType.view", ['lead_id' => $lead->id, 'prev_url' => $routeType]);
                    @endphp
                    <tr>
                        <td>{{ $currentIndex++ }}</td>
                        <td>{{ $lead->firstName.' '.$lead->lastName }}</td>
                        <td>{{ $lead->email ?? 'N/A' }}</td>
                        <td>{{ $phoneNumber ?? 'N/A' }}</td>
                        <td>{{ $lead->city }}</td>
                        <td>{{ $lead->state }}</td>
                        @if ($filter_type == "property")
                            <td>{{ ucfirst($lead->formPropertyType) }}</td>
                        @endif
                        <td>{{ $lead->created_at->format('d M, Y') . ' at ' .$lead->created_at->format('H:i:s') }}</td>
                        <td>
                            <a href="{{ $viewLeadHref }}">
                                <i class="fa fa-fw fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan=8 class="text-center">No Records Found.</td></tr>
            @endif
        </tbody>
    </table>

    <!-- Pagination Container -->
    <div id="pagination-container" class="text-center">
        @if (isset($totalPages))
            @for($pageNumber = 1; $pageNumber <= $totalPages; $pageNumber++)
                <button class="btn btn-secondary {{ $pageNumber == 1 ? 'active' : '' }}" style="margin: 0px 3px" onclick="renderByPage({{ $pageNumber }})">
                    {{ $pageNumber }}
                </button>
            @endfor
        @endif
    </div>
</div>
