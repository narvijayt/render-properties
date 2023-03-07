<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use App\Taxonomy;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

class BlogsController extends Controller
{
    /**
     * Admin blogs listing content
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request) {
        $data['page_title'] = 'Render | Admin | Blogs';
        $data['page_description'] = 'Admin | Blogs';

        $this->authorize('manage-blog', User::class);
        if($request->input('blog_profile') ){
            $data['blogs'] = Blog::where('blog_profile','=',$request->input('blog_profile'))->orderBy('id', 'DESC')->get();
        }else{
            $data['blogs'] = Blog::orderBy('id', 'DESC')->get();
        }
        
        return view('admin.blogs.index', $data);
    }

    /**
     * create blog
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function newBlog(Request $request) {
        
        $data['page_title'] = 'Render | Admin | New Blog';
        $data['page_description'] = 'Admin | New Blog';

        $this->authorize('manage-blog', User::class);

        $data['taxonomies'] = Taxonomy::orderBy('id', 'DESC')->get();
        return view('admin.blogs.partials.add', $data);
    }

    /**
     * save blog
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function createBlog(Request $request) {
        $input = $request->all();
        
        $blogValidations = [
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'taxonomy' => 'required',
            'blog_profile' => 'required',
        ];

        $messages = [
            'taxonomy.required' => 'Blog Category is required field.',
            'title.required' => 'Blog Title is required field.',
            'thumbnail.required' => 'Blog Thumbnail is required field.',
            'blog_profile.required' => 'Blog Profile is required field.',
            
        ];

        $v = Validator::make($input, $blogValidations, $messages);
        $date = date('Y-m-d H:i:s');

        if($v->passes()) {
            $this->authorize('manage-blog', User::class);
            
            $imageName = '';
            if ($request->hasFile('thumbnail')) {
                $imageName = time().'.'.$request->thumbnail->extension();  
                $request->thumbnail->move(public_path('images'), $imageName);
            }

            $blog = new Blog();
            $blog->title = $input['title'];
            $blog->description = $input['description'];
            $blog->excerpt = $input['excerpt'];
            $blog->taxonomy = $input['taxonomy'];
            $blog->blog_profile = $input['blog_profile'];
            $blog->video_embedded_link = $input['video_embedded_link'];
            $blog->thumbnail = $imageName;
            $blog->slug = $this->create_slug($input['title']);
            $blog->created_at = $date;
            $blog->updated_at = $date;
            $blog->save();

            return redirect('cpldashrbcs/blogs')->with('message', 'Blog has been created successfully!');
        } else {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
    }

    /**
     * @param Request $request
     * @return string
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function checkDuplicateBlog(Request $request) {
        $this->authorize('manage-blog', User::class);
        $input = $request->all();

        $blog = Blog::Where('title', $input['blog'])->first();
        if(isset($blog) && !empty($blog)) {
            return 'exist';
        }
    }

    /**
     * @param $post_title
     * @return string
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create_slug($text = ''){
        // return preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($post_title) );

        if(empty($text))
            return '';

        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicated - symbols
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
        return 'n-a';
        }

        return $text;
    }

    /**
     * Edit Content
     * @param $title
     * @param $id
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function editContent($id) {
        if($id == null) {
            return redirect('cpldashrbcs/blogs');
        }
        $this->authorize('manage-blog', User::class);
        $data['blog_id'] = $id;
        $data['blogs'] = Blog::find($id);
        $data['title'] = ucwords(str_replace('-',' ',$data['blogs']->title));
        $data['page_title'] = 'Render | Admin | '.$data['title'].' Blog';
        $data['page_description'] = 'Admin | '.$data['title'].' Blog';       

        $data['taxonomies'] = Taxonomy::orderBy('id', 'DESC')->get();
        return view('admin.blogs.partials.edit_content', $data);
    }

    /**
     * update blog
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateBlog(Request $request) {
        
        $input = $request->all();

        $blogValidations = [
            // 'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'taxonomy' => 'required',
            'blog_profile' => 'required',
        ];

        $messages = [
            'taxonomy.required' => 'Blog Category is required field.',
            'title.required' => 'Blog Title is required field.',
            // 'thumbnail.required' => 'Blog Thumbnail is required field.',
            'blog_profile.required' => 'Blog Profile is required field.',
        ];

        $v = Validator::make($input, $blogValidations, $messages);
        
        if($v->passes()) {
            $date = date('Y-m-d H:i:s');
            $this->authorize('manage-blog', User::class);
            
            $blog = Blog::find($input['id']);

            $imageName = $blog->thumbnail;
            if ($request->hasFile('thumbnail')) {
                $imageName = time().'.'.$request->thumbnail->extension();  
                $request->thumbnail->move(public_path('images'), $imageName);
            }

            $arr = array(
                'title' => $input['title'],
                'slug' => $this->create_slug($input['title']),
                'description' => $input['description'],
                'excerpt' => $input['excerpt'],
                'taxonomy' => $input['taxonomy'],
                'blog_profile' => $input['blog_profile'],
                'video_embedded_link' => $input['video_embedded_link'],
                'thumbnail' => $imageName,                
                'updated_at' => $date
            );

            Blog::where('id', $input['id'])->update($arr);
            return redirect('cpldashrbcs/blogs')->with('message', 'Blog has been updated successfully!');
        } else {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
    }
    
    /**
     * delete blog
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deleteBlog(Request $request) {
        
        $input = $request->all();
        
        $blogValidations = [
            'blog_id' => 'required',
        ];

        $v = Validator::make($input, $blogValidations);
        
        if($v->passes()) {
            $this->authorize('manage-blog', User::class);
            
            if(Blog::where('id', $input['blog_id'])->delete()){
                return redirect('cpldashrbcs/blogs')->with('message', 'Blog has been deleted successfully!');
            }else{
                return redirect('cpldashrbcs/blogs')->with('error', 'Failed to delete the Blog! Please try again later.');
            }
        } else {
            return redirect()->back()->withErrors($v->errors());
        }
    }



}