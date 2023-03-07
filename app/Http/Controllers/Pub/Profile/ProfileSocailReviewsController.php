<?php
namespace App\Http\Controllers\Pub\Profile;
use App\Enums\UserAccountType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\User;
use App\SocialReview;
use Carbon\Carbon;

class ProfileSocailReviewsController extends Controller
{
	/**
	 * Show action
	 *
	 * @param string $username
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function index() 
    {
        if(Auth::user()){
            $this->authorize('edit', $this->auth->user());
            
            $user = auth()->user();
            $socialReviews = SocialReview::where('userid','=',$user->user_id)->first();
            // echo '<pre>'; print_r($socialReviews); die;
            return view('pub.profile.socialreviews.index', compact('user','socialReviews'));
        }else{
            return redirect('login');
        }
    }
    
    /**
	 * Social Reviews update action
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request)
	{
		$user = $this->auth->user();
		
		$this->authorize('edit', $user);
		
		if($socialReviews = SocialReview::where('userid','=',$user->user_id)->first()){
		    $socialReview = SocialReview::find($socialReviews->id);
		}else{
            $socialReview = new SocialReview;
    		$socialReview->userid = $user->user_id;
		}
        
		$socialReview->zillow_screenname = $request->input('zillow_screenname');
	    $socialReview->facebook_embedded_review = $request->input('facebook_embedded_review');
	    $socialReview->yelp_embedded_review = $request->input('yelp_embedded_review');
	    $socialReview->save();

		flash('Success! Social Review details has been updated successfully.')->success();
		return redirect()->route('pub.profile.profileSocialReviews');
	}
}