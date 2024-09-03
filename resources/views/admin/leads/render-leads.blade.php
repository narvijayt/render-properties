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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        
            @if(isset($leads) && !empty($leads))
                @php $currentIndex = 1; @endphp
                @foreach($leads as $lead)
                    <tr>
                        <td>{{ $currentIndex++ }}</td>
                        <td>{{ $lead->firstName.' '.$lead->lastName }}</td>
                        <td>{{ $lead->email }}</td>
                        <td>{{ $lead->phoneNumber ?? 'N/A' }}</td>
                        <td>{{ $lead->city }}</td>
                        <td>{{ $lead->state }}</td>
                        <td>{{ ucfirst($lead->formPropertyType) }}</td>
                        <td>
                            <a href="{{ route('admin.leads.view', [ 'lead_id' => $lead->id ]) }}">
                                <i class="fa fa-fw fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>No Records Found.</tr>
            @endif
        </tbody>
    </table>
</div>
