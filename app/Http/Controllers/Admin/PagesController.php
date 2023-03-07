<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use App\Testimonial;
use App\User;
use App\Meta;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    /**
     * home page content
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index() {
        $data['page_title'] = 'Render | Admin | Pages';
        $data['page_description'] = 'Admin | Pages';

        $this->authorize('manage-page', User::class);
        $data['pages'] = Page::orderBy('id', 'ASC')->get();

        return view('admin.pages.index', $data);
    }

    /**
     * create page
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function newPage() {
        $data['page_title'] = 'Render | Admin | New Page';
        $data['page_description'] = 'Admin | New Page';

        $this->authorize('manage-page', User::class);

        return view('admin.pages.partials.add', $data);
    }

    /**
     * save page
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function createPage(Request $request) {
        $input = $request->all();
        $v = Validator::make($input, Page::$rules);
        $date = date('Y-m-d H:i:s');

        if($v->passes()) {
            $this->authorize('manage-page', User::class);

            $page = new Page();
            $page->title = $input['title'];
            $page->created_at = $date;
            $page->updated_at = $date;
            $page->save();

            return redirect('cpldashrbcs/pages');
        } else {
            return redirect()->back()->withErrors($v->errors());
        }
    }

    /**
     * @param Request $request
     * @return string
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function checkDuplicatePage(Request $request) {
        $this->authorize('manage-page', User::class);
        $input = $request->all();

        $page = Page::Where('title', $input['page'])->first();
        if(isset($page) && !empty($page)) {
            return 'exist';
        }
    }

    /**
     * Edit Content
     * @param $title
     * @param $id
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function editContent($title, $id) {
        if($title == null || $id == null) {
            return redirect('cpldashrbcs/pages');
        }
        $this->authorize('manage-page', User::class);
        $data['title'] = ucwords(str_replace('-',' ',$title));
        $data['page_id'] = $id;
        $data['pages'] = Page::find($id);
        $data['page_title'] = 'Render | Admin | '.$data['title'].' Page';
        $data['page_description'] = 'Admin | '.$data['title'].' Page';
        $meta = Meta::where('page_id','=',$id)->get();
        if($meta->isNotEmpty()){
            $findMeta = Meta::find($meta[0]->id);
            if(!is_null($findMeta->keyword)){
               $data['keyword'] = $findMeta->keyword;
            }else{
                $data['keyword'] = null;
            }
            if(!is_null($findMeta->description)){
                $data['description'] = $findMeta->description;
            }else{
                $data['description'] = null;
            }
        }else{
             $data['keyword'] = null;
             $data['description'] = null;
        }
        

        return view('admin.pages.partials.edit_content', $data);
    }

    /**
     * update page
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updatePage(Request $request) {
        $input = $request->all();
        $date = date('Y-m-d H:i:s');
        $this->authorize('manage-page', User::class);
        if(isset($input['footer'])) {
            $footer = $input['footer'];
        } else {
            $footer = null;
        }
        $arr = array('title' => $input['title'],
                     'header' => $input['header'],
                     'footer' => $footer,
                     'content' => $input['content'],
                     'updated_at' => $date);
        Page::where('id', $input['id'])->update($arr);
        $keyword = $input['meta_keyword'];
        $description = $input['meta_description'];
        if(!empty($keyword) || !empty($description)){
            $checkMeta = Meta::where('page_id','=',$input['id'])->get();
            if($checkMeta->isNotEmpty()){
                $updateMeta = Meta::find($checkMeta[0]->id);
                $updateMeta->keyword = $keyword;
                $updateMeta->description = $description;
                $updateMeta->update();
                
            }else{
                $createMeta = new Meta();
                $createMeta->page_id = $input['id']; 
                $createMeta->keyword = $keyword;
                $createMeta->description = $description;
                $createMeta->save();
             }
         }
     return redirect('cpldashrbcs/pages');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function testimonials() {
        $data['page_title'] = 'Render | Admin | Testimonials';
        $data['page_description'] = 'Admin | Testimonials';

        $this->authorize('manage-page', User::class);
        $data['testimonials'] = Testimonial::orderBy('id', 'DESC')->get();

        return view('admin.pages.testimonials', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function newTestimonial() {
        $data['page_title'] = 'Render | Admin | New Testimonial';
        $data['page_description'] = 'Admin | New Testimonial';

        $this->authorize('manage-page', User::class);

        return view('admin.pages.partials.testimonial.add', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function createTestimonial(Request $request) {
        $input = $request->all();
        $v = Validator::make($input, Testimonial::$rules);
        $date = date('Y-m-d');
        if(isset($input['image'])) {
            $img = $input['image'];
        } else {
            $img = null;
        }

        if($v->passes()) {
            $this->authorize('manage-page', User::class);

            $user = new Testimonial();
            $user->name = $input['name'];
            $user->description = $input['description'];
            $user->image = $img;
            $user->created_at = $date;
            $user->updated_at = $date;
            $user->save();

            return redirect('cpldashrbcs/testimonials');
        } else {
            return redirect()->back()->withErrors($v->errors());
        }
    }

    /**
     * @param $title
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function editTestimonial($id) {
        if($id == null) {
            return redirect('cpldashrbcs/testimonials');
        }
        $this->authorize('manage-page', User::class);
        $data['testimonial'] = Testimonial::find($id);
        $data['page_title'] = 'Render | Admin | Edit Testimonial';
        $data['page_description'] = 'Admin | Edit Testimonial';

        return view('admin.pages.partials.testimonial.edit', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateTestimonial(Request $request) {
        $input = $request->all();
        $date = date('Y-m-d');
        $this->authorize('manage-page', User::class);

        if(isset($input['image'])) {
            $img = $input['image'];
        } else {
            $img = null;
        }

        $arr = array('name' => $input['name'],
            'description' => '<p>'.$input['description'].'</p>',
            'image' => $img,
            'updated_at' => $date);

        Testimonial::where('id', $input['id'])->update($arr);

        return redirect('cpldashrbcs/testimonials');
    }

    /**
     * @param Request $request
     * @return string
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deleteTestimonial(Request $request) {
        $this->authorize('manage-page', User::class);
        $id = $request->get('id');
        Testimonial::Where('id', $id)->delete();
        return 'success';
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function viewTestimonial($id) {
        $data['page_title'] = 'Render | Admin | Show Testimonial';
        $data['page_description'] = 'Admin | Show Testimonial';

        $this->authorize('manage-page', User::class);
        $data['testimonial'] = Testimonial::find($id);

        return view('admin.pages.partials.testimonial.show', $data);
    }
}