<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HomePageBuilder;
use Auth;

class PageBuilderController extends Controller
{
    /**
     *  Index the Home Page Builder
     * 
     *  @since 1.0.0
     * 
     *  @return html
     */
    protected function editHomePage() {
        $data['getHomePage'] = HomePageBuilder::first();
        return view('admin.pages.edit-home-page', $data);
    }
    
    /**
     *  Update Page
     * 
     *  @since 1.0.0
     * 
     *  @return html
     */
    protected function updateHomePage(Request $request) {
        try {
            // dd($request->all());
            // Custom Validation Rules (Validator wasn't working)
            $formInputKeys = ['banner', 'section1', 'section2', 'section3', 'section4', 'section5'];

            foreach ($request->all() as $key => $value) {
                if (in_array($key, $formInputKeys)) {
                    if (is_null($value)) {
                        return \Redirect::back()->with('error', 'Please fill in all the required fields.');
                    }
                }
            }

            $getHomePage = HomePageBuilder::first();
            
            if (is_null($getHomePage)) {
                $homePage = new HomePageBuilder;
            } else {
                $homePage = HomePageBuilder::find($getHomePage->id);
            }
            
            $homePage->userId = Auth::user()->user_id;
            $homePage->banner = $request->banner;
            $homePage->section_1 = $request->section1;
            $homePage->section_2 = json_encode($request->section2);
            $homePage->section_3 = json_encode($request->section3);
            $homePage->section_4 = $request->section4;
            $homePage->section_5 = $request->section5;
            
            if ($homePage->save()) {
                return \Redirect::route('admin.pages.edit-home-page')->with('success', 'Home Page updated successfully.'); 
            } else {
                return \Redirect::back()->with('error', 'An unexpected error occurred while updating the Home page.');
            }


        } catch (\Exception $e) {
            return \Redirect::back()->with('error', 'Internal Server Error');
        }
    }
}
