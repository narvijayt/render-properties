@extends('layouts.app')

@section('content')

    <div class='banner connect'>
        <div class='container'>
            <div class='row'>
                Connect With Members
            </div>
        </div>
    </div>

    <div class="container">
        <form role="form">
            <div class="row">
                <div class="col-md-2">
                    <label>Narrow Search:</label>
                </div>
                <div class="col-md-1">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" /> Realtor
                        </label>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" /> Lender
                        </label>
                    </div>
                </div>
                <div class="col-md-2">
                    <select class="form-control">
                        <option>Charlotte</option>
                    </select>
                </div>
                <div class="col-md-2 col-md-offset-1">
                    221 Found
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-9">
                <div class="row top-buffer">
                    <div class="col-md-4">
                        <img src='img/dude.jpg' class='img-responsive center-block' />
                    </div>
                    <div class="col-md-2">
                        <strong>Name</strong><br/>
                        Company<br/>
                        City/State<br/>
                        Title<br/>
                        <img src='img/tate.gif' class='img-responsive top-buffer' />
                    </div>
                    <div class="col-md-2">
                        Years of Experience<br/>
                        $ Activity<br/>
                        Areas Served<br/>
                        Specialties
                    </div>
                    <div class="col-md-4">
                        Rating<br/>
                        <span class='fa fa-home'></span><span class='fa fa-home'></span><span class='fa fa-home'></span><span class='fa fa-home'></span><span class='fa fa-home'></span><br/>
                        <a href='#'>Reviews(5)</a><br/>
                        <a href='#' class='btn btn-warning'>View Member Profile</a>

                    </div>
                </div>

                <div class="row top-buffer">
                    <div class="col-md-4">
                        <img src='img/dudette.jpg' class='img-responsive' />
                    </div>
                    <div class="col-md-2">
                        <strong>Name</strong><br/>
                        Company<br/>
                        City/State<br/>
                        Title<br/>
                        <img src='img/tate.gif' class='img-responsive top-buffer' />
                    </div>
                    <div class="col-md-2">
                        Years of Experience<br/>
                        $ Activity<br/>
                        Areas Served<br/>
                        Specialties
                    </div>
                    <div class="col-md-4">
                        Rating<br/>
                        <span class='fa fa-home'></span><span class='fa fa-home'></span><span class='fa fa-home'></span><span class='fa fa-home'></span><span class='fa fa-home'></span><br/>
                        <a href='#'>Reviews(5)</a><br/>
                        <a href='#' class='btn btn-warning'>View Member Profile</a>

                    </div>
                </div>

            </div>

            <div class="sponsors col-md-3">
                <h4>Sponsors</h4>
                <img src="img/sponsor_1.jpg" class="img-responsive">
                <img src="img/sponsor_2.jpg" class="img-responsive">
            </div>
        </div>
    </div>
@endsection