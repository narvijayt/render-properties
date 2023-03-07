@extends('layouts.app')
@section('title') Blog @endsection
@section('meta')
{{ meta('description','Blog - Render') }}
{{ meta('keywords', config('seo.keyword')) }}

     @php
        $description = 'Blog - Render'
    @endphp
    {{ openGraph('og:title', 'Blog') }}
    {{ openGraph('og:type', 'article') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}
    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', 'Blog') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}
    {{ googlePlus('name', 'Blog') }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection

@section('content')
    {{--
        @component('pub.components.banner', ['banner_class' => 'blogs-listing'])
            <h1 class="banner-title">{{$blog->title}}</h1>
        @endcomponent
    --}}

    <div class="blogs-container single-blog container">
        @if(isset($blog) && !empty($blog))
            <div class="row blog-details">
		<div class="col-md-12">
                    <h1 class="mt-1">{{ $blog->title}}</h1>
                   </div>
                <div class="col-md-12 text-center">
                    <div class="thumbnail-box ">
                        @if($blog->video_embedded_link)
                            <div class="video-container mb-1">
                                @php echo $blog->video_embedded_link; @endphp
                            </div>
                         @elseif($blog->thumbnail)
                           <!--- <img src="{{asset('images').'/'.$blog->thumbnail}}" /> -->
                        @else
                            <!---<img src="https://picsum.photos/300/300" />-->
                        @endif  
					</div>
                </div> 
                <div class="col-md-12">
                    <div class="text text-info">
                        @php echo html_entity_decode($blog->description); @endphp    
                    </div>
                </div>
            </div>
        @endif

        
        @if($relatedBlogs)
        <div class="related-articles-container">
            <h4>Other Articles You Might Like</h4>
            <div class="row">
                @foreach($relatedBlogs as $article)
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="thumbnail-box">
                                    @if($article->blog_profile == "Lenders")
                                        <a class="heading_link" href="{{ route('lenderBlogView', ['title' =>$article->slug]) }}">
                                    @elseif($article->blog_profile == "Agents")
                                        <a class="heading_link" href="{{ route('agentBlogView', ['title' =>$article->slug]) }}">
                                    @endif
                                        
                                        @if($article->thumbnail)
                                            <img src="{{asset('images').'/'.$article->thumbnail}}" />
                                        @else
                                            <img src="https://picsum.photos/300/300" />
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12">
                                @if($article->blog_profile == "Lenders")
                                    <a class="heading_link" href="{{ route('lenderBlogView', ['title' =>$article->slug]) }}"><h2 class="mt-1">{{ $article->title}}</h2></a>
                                @elseif($article->blog_profile == "Agents")
                                    <a class="heading_link" href="{{ route('agentBlogView', ['title' =>$article->slug]) }}"><h2 class="mt-1">{{ $article->title}}</h2></a>
                                @endif
                                
                                <div class="text text-info">@php echo str_limit($article->excerpt, $limit = 200, $end = '...') @endphp</div>
                                
                                @if($article->blog_profile == "Lenders")
                                    <a class="btn btn-warning util__mb--small mt-1" href="{{ route('lenderBlogView', ['title' =>$article->slug]) }}">Read More</a>
                                @elseif($article->blog_profile == "Agents")
                                    <a class="btn btn-warning util__mb--small mt-1" href="{{ route('agentBlogView', ['title' =>$article->slug]) }}">Read More</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

@endsection