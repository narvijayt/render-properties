@extends('layouts.app')
@section('title') Blogs @endsection
@section('meta')
{{ meta('description','Blogs - Render') }}
{{ meta('keywords', config('seo.keyword')) }}

     @php
        $description = 'Blogs - Render'
    @endphp
    {{ openGraph('og:title', 'Blogs') }}
    {{ openGraph('og:type', 'article') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}
    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', 'Blogs') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}
    {{ googlePlus('name', 'Blogs') }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection

@section('content')
    @component('pub.components.banner', ['banner_class' => 'blogs-listing'])
        <h1 class="banner-title">@php echo (isset($blog_title)) ? $blog_title: "Blog" @endphp</h1>
    @endcomponent

    <div class="blogs-container container">
        @if(isset($blogs) && !empty($blogs))
            @foreach($blogs as $blog)
                <div class="row">
                    <div class="col-md-4">
					    <div class="thumbnail-box">
					        
                            @if($blog->blog_profile == "Lenders")
                                <a class="heading_link" href="{{ route('lenderBlogView', ['title' =>$blog->slug]) }}">
                            @elseif($blog->blog_profile == "Agents")
                                <a class="heading_link" href="{{ route('agentBlogView', ['title' =>$blog->slug]) }}">
                            @endif
                            
                            @if($blog->thumbnail)
                                <img src="{{asset('images').'/'.$blog->thumbnail}}" />
                            @else
                                <img src="https://picsum.photos/300/300" />
                            @endif
                            </a>
						</div>
                    </div>
                    <div class="col-md-8 mb-2">
                        @if($blog->blog_profile == "Lenders")
                            <a class="heading_link" href="{{ route('lenderBlogView', ['title' =>$blog->slug]) }}">
                        @elseif($blog->blog_profile == "Agents")
                            <a class="heading_link" href="{{ route('agentBlogView', ['title' =>$blog->slug]) }}">
                        @endif
                            <h2 class="mt-1">{{ $blog->title}}</h2>
                        </a>
                        
                        <div class="text text-info">
                            @php echo ($blog->excerpt) ? str_limit($blog->excerpt, $limit = 300, $end = '...') : str_limit(html_entity_decode($blog->description), $limit = 300, $end = '...'); @endphp
                        </div>
                        <!-- <a class="btn btn-warning util__mb--small" href="{{url("blogs/{$blog->slug}")}}">Read More</a> -->
                        @if($blog->blog_profile == "Lenders")
                            <a class="btn btn-warning util__mb--small mt-1" href="{{ route('lenderBlogView', ['title' =>$blog->slug]) }}">Read More</a>
                        @elseif($blog->blog_profile == "Agents")
                            <a class="btn btn-warning util__mb--small mt-1" href="{{ route('agentBlogView', ['title' =>$blog->slug]) }}">Read More</a>
                        @endif
                    </div>
                </div>
            @endforeach

            {{ $blogs->links() }}
        @else
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="alert alert-warning">No Blog available</div>
            </div>
        </div>
        @endif
    </div>

@endsection