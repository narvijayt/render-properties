@extends('layouts.app')
@section('title') Contact Us @endsection
@section('meta')
    @if(!empty($contactPagemeta))
    @if(!is_null($contactPagemeta->description))
    {{ meta('description', html_entity_decode(strip_tags($contactPagemeta->description))) }}
    @else
    {{ meta('description', 'Contact Render') }}
    @endif
    @if(!is_null($contactPagemeta->keyword))
    {{ meta('keywords', html_entity_decode(strip_tags($contactPagemeta->keyword))) }}
    @else
    {{ meta('keywords', config('seo.keyword')) }}
    @endif
    @else
    {{ meta('description', 'Contact Render') }}
    {{ meta('keywords', config('seo.keyword')) }}
    @endif
    @php
    $description = 'Contact Render'
    @endphp
    {{ openGraph('og:title', 'Contact Us') }}
    {{ openGraph('og:type', 'product') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}
    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', 'Contact Us') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}
    {{ googlePlus('name', 'Contact Us') }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
 @endsection

@section('content')

    @component('pub.components.banner', ['banner_class' => 'contact'])
        <h1 class="banner-title">Contact Us</h1>
    @endcomponent

    <div class="container">
        <div class="row top-buffer">
            <div class="col-md-4">
                 @if(isset($contactPage) && !empty($contactPage))
                        @if($contactPage->content != '')
                            @php echo html_entity_decode($contactPage->content); @endphp
                        @endif
                    @endif

            </div>


            <div class="col-md-5">
                @if (Session::has('message'))
                    <p class="alert alert-success">
                        <strong>Thank you</strong> for submitting a contact request
                    </p>
                @endif
                <form role="form" action="{{ route('pub.contact.send') }}" method="POST" id="contact-form">
                    {{ csrf_field() }}
                    <div>
                        <div class="row">

                            <div class="col-md-6 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    value="{{old('name')}}"
                                    placeholder="Name">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="phone"
                                    value="{{old('phone')}}"
                                    placeholder="Phone">
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <input
                            type="email"
                            class="form-control"
                            name="email"
                            value="{{old('email')}}"
                            placeholder="Email">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
                        <input
                            type="text"
                            class="form-control"
                            name="subject"
                            value="{{old('subject')}}"
                            placeholder="Subject">
                        @if ($errors->has('subject'))
                            <span class="help-block">
                                <strong>{{ $errors->first('subject') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                        <textarea
                            class="form-control"
                            rows="3"
                            name="message"
                            placeholder="Message">{{ old('message') }}</textarea>
                        @if ($errors->has('message'))
                            <span class="help-block">
                                <strong>{{ $errors->first('message') }}</strong>
                            </span>
                        @endif
                    </div>
                    <script src="https://www.google.com/recaptcha/api.js"></script>
                     <div class="form-group recaptcha">
                        {!! app('captcha')->display() !!}
                       {!! $errors->first('captcha-response', '<p class="alert alert-danger">:message</p>') !!}
                    </div>
                    </br>
                
                      <button type="submit" class="btn btn-warning btn-block">Send</button>
                </form>
            </div>
			
			<div class="col-md-3">
			   <!-- /21803544343/RBC-HP -->
					<div id='div-gpt-ad-1552396650444-0' style='height:600px; width:300px;'>
					<script>
					googletag.cmd.push(function() { googletag.display('div-gpt-ad-1552396650444-0'); });
					</script>
					</div>
	
			  </div>
			
        </div>
    </div>
    
@endsection
