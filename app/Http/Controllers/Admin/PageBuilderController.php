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
            // We will add validations later.
            $validate = [
                'banner' => 'required',
                'section_1' => 'required',
                'section_2' => 'required',
                'section_3' => 'required',
                'section_4' => 'required',
                'section_5' => 'required',
            ];

            $request->validate($validate);
            
            $getHomePage = HomePageBuilder::first();
            if (is_null($getHomePage)) {
                $homePage = new HomePageBuilder;
            } else {
                $homePage = HomePageBuilder::find($getHomePage->id);
            }
            $homePage->userId = Auth::user()->user_id;
            $homePage->banner = $request->banner;
            $homePage->section_1 = $request->section1;
            $homePage->section_2 = $request->section2;
            $homePage->section_3 = $request->section3;
            $homePage->section_4 = $request->section4;
            $homePage->section_5 = $request->section5;
            if ($homePage->save()) {
                return redirect()->route('admin.pages.edit-home-page')->with('success', 'Home Page updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Home Page updation failed.');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }
}
