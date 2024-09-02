@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
    <h1>All Leads</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Leads</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif

                <div class="box">
                    <div class="box-header">
                        <div class="col-md-10">
                            <h4>Leads</h4>
                        </div>
                        <div class="col-md-2 text-right">
                            <h4>Total: {{ $leads_count }}</h4>
                        </div>
                    </div>
                    <div class="box-body">
                        <form class="lead-form" id="filter-lead-form" action="{{ route('admin.leads.filter') }}" method="post">
                            <!-- Search types -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-input">
                                        <label>Search By</label>
                                        <select class="form-control" name="search_type" id="lead_search_type">
                                            <option value="all">All</option>
                                            <option value="name">Name</option>
                                            <option value="email">Email</option>
                                            <option value="phone_number">Phone Number</option>
                                            <option value="state">State</option>
                                            <option value="city">City</option>
                                            <option value="form_type">Form Type</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Value -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Value</label>
                                    <div class="form-input">
                                        <input class="form-control" type="text" name="search_value" id="search_value_input" />    

                                        <!-- New select dropdown for filtering by "sell" and "buy" -->
                                        <select name="search_option_value" class="form-control" id="search_value_option">
                                            <option value="" selected>Select Form Type</option>
                                            <option value="sell">Sell</option>
                                            <option value="buy">Buy</option>
                                        </select>
                                    </div>
                                    <p class="text-red lead-field-error"></p>
                                </div>
                            </div>

                            <!-- Apply Filter -->
                            <div class="col-md-3">
                                <label>&nbsp;</label>
                                <div class="form-input">
                                    <button type="button" id="filter_leads" name="filter_leads" class="btn btn-success">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="box-body lead_data_content"></div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts-footer')
<script>
console.log();

// $(document).ready(function() {
//     $("#filter_leads").click(function(){
//         alert("button");
//     }); 

//     var formData = new FormData(document.querySelector('form'));
// });

// $(document).ready(function(){
//     $(document).on("click", "button[name='filter_leads']", function(){
//         console.log(1);
//         // showLoader(true);
//         // $(".ajax-response").addClass('d-none').find(".alert").removeClass('alert-danger alert-success').text('');
//         // const route = $(this).closest("form").attr("action");
//         // console.log(route);
//         // break;
//         // const form = document.getElementById('lead-form');
//         // const formData = new FormData(form);
//         // formData.append("_token", "{{ csrf_token() }}");
//         // ajaxRequestFormData(route, "POST", formData).then(response => {
//         //     console.log("response ", response);
//         //     // if($("input[name='salesReportId']").val() == ""){
//         //     //     $("input[name='salesReportId']").val(response.data.id);
//         //     // }
//         //     // $(".ajax-response").removeClass('d-none').find(".alert").addClass('alert-success').text('Report has been saved as Draft Successfully.');
//         //     // hideLoader();
//         // }).catch(error => {
//         //     if (error.responseText) {
//         //         const errorMessagess = $.parseJSON(error.responseText);
//         //         console.log('errorMessagess ', errorMessagess.message);
//         //         // $(".ajax-response").removeClass('d-none').find(".alert").addClass('alert-danger').text(errorMessagess.message);
//         //     }
//         //     // hideLoader();
//         // });
//     });
// });

function ajaxRequest(route, method, data){
    return new Promise((resolve, reject) => {
        $.ajax({
            url: route,
            type: method,
            data: data,
            success: function (data) {
                resolve(data)
            },
            error: function (error) {
                reject(error)
            },
        })
    })
}

function ajaxRequestFormData(route, method, data){
    return new Promise((resolve, reject) => {
        $.ajax({
            url: route,
            type: method,
            data: data,
            processData: false,
            contentType: false,
            success: function (data) {
                resolve(data)
            },
            error: function (error) {
                reject(error)
            },
        })
    })
}

</script>
@endpush