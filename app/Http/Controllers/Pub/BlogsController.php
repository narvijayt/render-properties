<?php

namespace App\Http\Controllers\Pub;

use App\Http\Controllers\Controller;
use App\Blog;

class BlogsController extends Controller
{
	public function index()
	{
        $data['blogs'] = Blog::orderBy('id', 'DESC')->paginate(10);
        return view('pub.blogs.index', $data);
	}
	
	public function lendersindex()
	{
        $data['blogs'] = Blog::where('blog_profile', '=', 'Lenders')->orderBy('id', 'DESC')->paginate(10);
        $data['blog_title'] = "Mortgage Blog";
        return view('pub.blogs.index', $data);
	}
	
	public function aganetsindex()
	{
        $data['blogs'] = Blog::where('blog_profile', '=', 'Agents')->orderBy('id', 'DESC')->paginate(10);
        $data['blog_title'] = "Real Estate Blog";
        return view('pub.blogs.index', $data);
	}

    public function viewBlog($slug)
	{
        $data['blog'] = Blog::where('slug', '=', $slug)->first();
        if(count($data['blog']) > 0){
            $data['relatedBlogs'] = Blog::where([ ['taxonomy', '=', $data['blog']->taxonomy],['id', '!=', $data['blog']->id],['blog_profile', '=', $data['blog']->blog_profile] ] )->inRandomOrder()->take(4)->get();
            return view('pub.blogs.view', $data);
        }else{
            return redirect()->route('lendersBlogListing')->with('error','No such Blog available.');
        }
	}
}
