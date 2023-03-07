<?php

namespace App\Http\Controllers\Admin;

use App\Taxonomy;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

class TaxonomyController extends Controller
{
    /**
     * Admin taxonomies listing content
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index() {
        $data['page_title'] = 'Render | Admin | Categories';
        $data['page_description'] = 'Admin | Categories';

        $this->authorize('manage-taxonomy', User::class);
        $data['taxonomies'] = Taxonomy::orderBy('id', 'DESC')->get();

        return view('admin.taxonomies.index', $data);
    }

    /**
     * create taxonomy
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function newTaxonomy() {
        $data['page_title'] = 'Render | Admin | New Category';
        $data['page_description'] = 'Admin | New Category';

        $this->authorize('manage-taxonomy', User::class);

        return view('admin.taxonomies.partials.add', $data);
    }

    /**
     * save taxonomy
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function createTaxonomy(Request $request) {
        $input = $request->all();
        
        $taxonomyValidations = [
            'name' => 'required',
        ];

        $v = Validator::make($input, $taxonomyValidations);
        $date = date('Y-m-d H:i:s');

        if($v->passes()) {
            $this->authorize('manage-taxonomy', User::class);

            $taxonomy = new Taxonomy();
            $taxonomy->name = $input['name'];
            $taxonomy->description = $input['description'];
            $taxonomy->slug = $this->create_slug($input['name']);
            $taxonomy->created_at = $date;
            $taxonomy->updated_at = $date;
            $taxonomy->save();

            return redirect('cpldashrbcs/taxonomies')->with('message', 'Category has been created successfully!');
        } else {
            return redirect()->back()->withErrors($v->errors());
        }
    }

    /**
     * @param Request $request
     * @return string
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function checkDuplicateTaxonomy(Request $request) {
        $this->authorize('manage-taxonomy', User::class);
        $input = $request->all();

        $taxonomy = Taxonomy::Where('name', $input['taxonomy'])->first();
        if(isset($taxonomy) && !empty($taxonomy)) {
            return 'exist';
        }
    }

    /**
     * @param $post_name
     * @return string
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create_slug($text = ''){
        // return preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($post_name) );

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
     * @param $name
     * @param $id
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function editContent($id) {
        if($id == null) {
            return redirect('cpldashrbcs/taxonomies');
        }
        $this->authorize('manage-taxonomy', User::class);
        $data['taxonomy_id'] = $id;
        $data['taxonomies'] = Taxonomy::find($id);
        $data['title'] = ucwords(str_replace('-',' ',$data['taxonomies']->name));
        $data['page_title'] = 'Render | Admin | '.$data['title'].' Category';
        $data['page_description'] = 'Admin | '.$data['title'].' Category';       

        return view('admin.taxonomies.partials.edit_content', $data);
    }

    /**
     * update taxonomy
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateTaxonomy(Request $request) {
        
        $input = $request->all();

        $taxonomyValidations = [
            'name' => 'required',
        ];

        $v = Validator::make($input, $taxonomyValidations);
        
        if($v->passes()) {
            $date = date('Y-m-d H:i:s');
            $this->authorize('manage-taxonomy', User::class);
            
            $arr = array(
                'name' => $input['name'],
                'slug' => $this->create_slug($input['name']),
                'description' => $input['description'],
                'updated_at' => $date
            );

            Taxonomy::where('id', $input['id'])->update($arr);
            return redirect('cpldashrbcs/taxonomies')->with('message', 'Category has been updated successfully!');
        } else {
            return redirect()->back()->withErrors($v->errors());
        }
    }
    
    /**
     * delete taxonomy
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deleteTaxonomy(Request $request) {
        
        $input = $request->all();
        
        $taxonomyValidations = [
            'taxonomy_id' => 'required',
        ];

        $v = Validator::make($input, $taxonomyValidations);
        
        if($v->passes()) {
            $this->authorize('manage-taxonomy', User::class);
            
            if(Taxonomy::where('id', $input['taxonomy_id'])->delete()){
                return redirect('cpldashrbcs/taxonomies')->with('message', 'Category has been deleted successfully!');
            }else{
                return redirect('cpldashrbcs/taxonomies')->with('error', 'Failed to delete the Category! Please try again later.');
            }
        } else {
            return redirect()->back()->withErrors($v->errors());
        }
    }



}