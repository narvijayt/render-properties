<div class="loader c-loader" id="loader-2">
    <span></span>
    <span></span>
    <span></span>
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
                <th>Sell / Buy</th>
                <th>Received On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        
            @if(isset($leads) && $leads->isNotEmpty())
                @php $currentIndex = $startIndex; @endphp
                @foreach($leads as $lead)
                    <tr>
                        <td>{{ $currentIndex++ }}</td>
                        <td>{{ $lead->firstName.' '.$lead->lastName }}</td>
                        <td>{{ $lead->email }}</td>
                        <td>{{ $lead->phoneNumber ?? 'N/A' }}</td>
                        <td>{{ $lead->city }}</td>
                        <td>{{ $lead->state }}</td>
                        <td>{{ ucfirst($lead->formPropertyType) }}</td>
                        <td>{{ $lead->created_at->format('d M, Y') . ' at ' .$lead->created_at->format('H:i:s') }}</td>
                        <td>
                            <a href="{{ route('admin.leads.view', [ 'lead_id' => $lead->id ]) }}">
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
