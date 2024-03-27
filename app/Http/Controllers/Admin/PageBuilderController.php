<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HomePageBuilder;
use Auth;
use App\RealtorRegisterPageBuilder;
use App\LenderRegisterPageBuilder;
use App\VendorRegisterPageBuilder;

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
            
            $validator = \Validator::make($request->all(), HomePageBuilder::$rules, HomePageBuilder::$messages);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }
            
            $getHomePage = HomePageBuilder::first();
            if (is_null($getHomePage)) {
                $getHomePage = new HomePageBuilder;
                $getHomePage->userId = Auth::user()->user_id;
            } 
            
            $getHomePage->banner = $request->banner;
            $getHomePage->section_1 = $request->section1;
            $getHomePage->section_2 = json_encode($request->section2);
            $getHomePage->section_3 = json_encode($request->section3);
            $getHomePage->section_4 = $request->section4;
            $getHomePage->section_5 = $request->section5;

            if ($getHomePage->save()) {
                return \Redirect::route('admin.pages.edit-home-page')->with('success', 'Home Page updated successfully.'); 
            } else {
                return \Redirect::back()->with('error', 'An unexpected error occurred while updating the Home page.');
            }


        } catch (\Exception $e) {
            return \Redirect::back()->with('error', 'Internal Server Error');
        }
    }


    /**
     * Index Realtor Register page.
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    protected function editRealtorRegisterPage() {
        $data['getRealtorRegisterPage'] = RealtorRegisterPageBuilder::first();
        return view('admin.pages.edit-realtor-register-page', $data);
    }

    /**
     *  Index Lender Register Page
     * 
     *  @since 1.0.0
     * 
     *  @return html
     */
    protected function editLenderRegisterPage() {
        $data['getlenderRegisterPage'] = LenderRegisterPageBuilder::first();
        // dd($data['getlenderRegisterPage']);
        return view('admin.pages.edit-lender-register-page', $data);
    }
    
    /**
     *  Index Vendor Register Page
     * 
     *  @since 1.0.0
     * 
     *  @return html
     */
    protected function editVendorRegisterPage() {
        $data['getVendorRegisterPage'] = VendorRegisterPageBuilder::first();
        return view('admin.pages.edit-vendor-register-page', $data);
    }

    /**
     * Update Register Page
     * 
     * @since 1.0.0
     * 
     * @return html
     */
    protected function updateRegisterPage(Request $request) {
        try {            
            $formInputKeys = ['banner', 'sectionOneHeader', 'section1', 'section2'];
            $errorMessage = "Please fill in all the required fields.";

            // Check if the key 'section1' is present in the incoming request keys.
            if (!in_array('section1', array_keys($request->all()))) {
                return \Redirect::back()->with('error', $errorMessage)->withInput($request->input());
            }

            // Check if the incoming request keys are present in formInputKeys array.
            foreach ($request->all() as $key => $value) {
                if (in_array($key, $formInputKeys)) {                    
                    // Section 1 will be an array, so check if this is an array, then loop over it and verify that on traversal values should not be empty.
                    if (is_array($request->section1)) {
                        foreach ($request->section1 as $innerValue) {
                            if (is_null($innerValue)) {
                                return \Redirect::back()->with('error', $errorMessage)->withInput($request->input());
                            }
                        }
                    }
                    
                    // Return error if the key value is null
                    if (is_null($value)) {
                        return \Redirect::back()->with('error', $errorMessage)->withInput($request->input());
                    }
                }
            }

            // Define page builder classes
            $pageBuilders = [
                "lender" => LenderRegisterPageBuilder::class,
                "realtor" => RealtorRegisterPageBuilder::class,
                "vendor" => VendorRegisterPageBuilder::class,
            ];

            // If wrong page is set, then show the error message.
            if (!isset($pageBuilders[$request->page])) {
                return \Redirect::back()->with('error', 'Something went wrong. Please try again later.');
            }

            $builderClass = $pageBuilders[$request->page];
            $registerPage = $builderClass::first();
            if (is_null($registerPage)) {
                $registerPage = new $builderClass;
                $registerPage->userId = Auth::user()->user_id;
            }

    
            $registerPage->banner = $request->banner;
            $registerPage->section_1_Header = $request->sectionOneHeader;
            $registerPage->section_1 = json_encode($request->section1);
            $registerPage->section_2 = $request->section2;
            
            if ($registerPage->save()) {
                return \Redirect::route('admin.pages.edit-'.$request->page.'-register-page')->with('success', ''.ucfirst($request->page).' register page updated successfully.');
            } else {
                return \Redirect::back()->with('error', 'An unexpected error occurred while updating the '.$request->page.' register page.');
            }
            
        } catch (\Exception $e) {
            return \Redirect::back()->with('error', 'Internal Server Error'. $e->getMessage());
        }
    }

}