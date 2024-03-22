<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HomePageBuilder;
use Auth;
use App\RealtorRegisterPageBuilder;

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
            
            // Custom Validation Rules (Validator wasn't working)
            $formInputKeys = ['banner', 'section1', 'section2', 'section3', 'section4', 'section5'];
            $errorMessage = "Please fill in all the required fields.";

            foreach ($request->all() as $key => $value) {
                if (in_array($key, $formInputKeys)) {
                    if (is_null($value)) {
                        return \Redirect::back()->with('error', $errorMessage);
                    }

                    // Didn't use the merge approach as we have same key names
                    $section2Array = array_values($request->section2);
                    $section3Array = array_values($request->section3);

                    foreach ($section2Array as $value) {
                        if (is_null($value)) {
                            return \Redirect::back()->with('error', $errorMessage);
                        }
                    }

                    foreach ($section3Array as $value) {
                        if (is_null($value)) {
                            return \Redirect::back()->with('error', $errorMessage);
                        }
                    }
                }
            }

            $getHomePage = HomePageBuilder::first();
            
            if (is_null($getHomePage)) {
                $homePage = new HomePageBuilder;
                $homePage->userId = Auth::user()->user_id;
            } else {
                $homePage = HomePageBuilder::find($getHomePage->id);
            }
            
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


    protected function editRealtorRegisterPage() {
        return view('admin.pages.edit-realtor-register-page');
    }


    protected function updateRealtorRegisterPage() {
        try {
            // Custom Validation Rules (Validator wasn't working)
            $formInputKeys = ['banner', 'section1', 'section2'];
            $errorMessage = "Please fill in all the required fields.";

            foreach ($request->all() as $key => $value) {
                if (in_array($key, $formInputKeys)) {
                    if (is_null($value)) {
                        return \Redirect::back()->with('error', $errorMessage);
                    }

                    // Didn't use the merge approach as we have same key names
                    $section2Array = array_values($request->section2);
                    $section3Array = array_values($request->section3);

                    foreach ($section2Array as $value) {
                        if (is_null($value)) {
                            return \Redirect::back()->with('error', $errorMessage);
                        }
                    }

                    foreach ($section3Array as $value) {
                        if (is_null($value)) {
                            return \Redirect::back()->with('error', $errorMessage);
                        }
                    }
                }
            }

            $getRealtorRegisterPage = RealtorRegisterPageBuilder::first();
            
            if (is_null($getRealtorRegisterPage)) {
                $getRealtorRegisterPage = new RealtorRegisterPageBuilder;
                $homePage->userId = Auth::user()->user_id;
            } else {
                $getRealtorRegisterPage = RealtorRegisterPageBuilder::find($getRealtorRegisterPage->id);
            }

            $homePage->banner = $request->banner;
            $homePage->section_1 = $request->section1;
            $homePage->section_2 = json_encode($request->section2);

            if ($homePage->save()) {
                return \Redirect::route('admin.pages.edit-realtor-register-page')->with('success', 'Realtor Register Page updated successfully.'); 
            } else {
                return \Redirect::back()->with('error', 'An unexpected error occurred while updating the Realtor Register page.');
            }
            
        } catch (\Exception $e) {
            return \Redirect::back()->with('error', 'Internal Server Error');
        }
    }
}
