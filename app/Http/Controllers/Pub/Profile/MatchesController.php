<?php

namespace App\Http\Controllers\Pub\Profile;

use App\Enums\MatchPurchaseType;
use App\Events\Matching\NewMatch;
use App\Events\Matching\NewMatchSuccess;
use App\Events\Matching\Renew;
use App\Events\Matching\RenewSuccess;
use App\Http\Controllers\Controller;
use App\Match;
use App\MatchPurchase;
use App\User;
use Mail;
use Auth;
use App\Mail\MatchRequestEmail;
use App\Mail\MatchLendorRequestEmail;
use App\Mail\ConfirmMatchRequestEmail;
use App\Mail\RenewMatchRequestEmail;
use App\Mail\ConfirmRenewMatchRequestEmail;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Log;

class MatchesController extends Controller
{
	/**
	 * Profile index action
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		/** @var User $user */
		$user  = User::with('userSubscription')->find(Auth::user()->user_id);

		$matches = Match::findForUser($user, true);
        $matches->load('renewal');
		$activeMatches = $matches->filter(function(Match $match) use ($user) {
			return $match->isActive();
		});
		$pendingMatches = $matches->filter(function(Match $match) {
			return !$match->isAccepted() && !$match->isDeleted();
		});
		$renewableMatches = $matches->filter(function($match) {
			return $match->deleted_at !== null;
		});
        $usedMatchesCount = $matches->filter(function(Match $match) use ($user) {
			return $match->isAcceptedBy($user);
		})->count();
    	$purchasedMatchesCount = MatchPurchase::where('user_id', auth()->user()->user_id)->sum('quantity');
        return view('pub.profile.matches.index', compact(
			'user',
			'activeMatches',
			'pendingMatches',
			'renewableMatches',
			'usedMatchesCount',
			'purchasedMatchesCount'
		));
	}

    	/* 
	** match request 
	*/
	public function matchRequestEmail(User $user)
	{
        
        try {
            $email = new MatchRequestEmail($user);
		    Mail::to($user->email)->send($email);

            return back();
        } catch(Exception $e) {
            echo "catch";
            return back();
        }
    }
    	
    
    /* 
	** Lendor match request to realtor
	*/
	public function matchLendorRequestEmail(User $user)
	{
        
        try {
            $email = new MatchLendorRequestEmail($user);
		    Mail::to($user->email)->send($email);

            return back();
        } catch(Exception $e) {
            echo "catch";
            return back();
        }
    }
    
	/* 
	** accepted match request 
	*/
	public function confirmMatchRequestEmail(User $user)
	{
        
        try {
            $email = new ConfirmMatchRequestEmail($user);
		    Mail::to($user->email)->send($email);

            return back();
        } catch(Exception $e) {
            echo "catch";
            return back();
        }
    }
    
	/* 
	** renew match request 
	*/
	public function renewMatchRequestEmail(User $user)
	{
        
        try {
            $email = new RenewMatchRequestEmail($user);
		    Mail::to($user->email)->send($email);

            return back();
        } catch(Exception $e) {
            echo "catch";
            return back();
        }
    }
    
    /* 
	**confirm renew match request 
	*/
	public function confirmRenewMatchRequestEmail(User $user)
	{
        
        try {
            $email = new ConfirmRenewMatchRequestEmail($user);
		    Mail::to($user->email)->send($email);

            return back();
        } catch(Exception $e) {
            echo "catch";
            return back();
        }
    }


	/**
	 * Request a match with a user
	 *
	 * @param User $user
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function requestMatch(User $user)
	{
		//$this->authorize('requestMatch', $user);
        $authUser = $this->auth->user();
        /** @var \App\Services\Matching\Matching $matchingService */
		$matchingService = app()->make(\App\Services\Matching\Matching::class);
		$match = $matchingService->request($authUser, $user);
		if ($match !== false) {
			flash('Match request sent!')->success();
			if($authUser->user_type == "broker" && $user->user_type == "realtor"){
                $this->matchLendorRequestEmail($user);
            }else{
                $this->matchRequestEmail($user);
            }
			try{
				(new TwilioService())->sendNewRequestMatchNotification($authUser, $user);
			}catch(Exception $e){
                          
			}
           	event(new NewMatch($match, $user));
		} else {
			flash('Unable to send match request')->error();
		}
	return redirect()->back();
	}

	/**
	 * Confirm a match with a user
	 *
	 * @param User $user
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function confirmMatch(Match $match)
	{
		$authUser = $this->auth->user();
		/*if($authUser->user_type == "realtor"){
			$realtorUser = User::find($authUser->user_id);
			$matches = Match::findForUser($realtorUser, true);
        	if($matches->count() ){
				flash('You are already connected with a loan officer in same area.')->error();
				return redirect()->back();
			}
		}*/
		
		$user = $match->getOppositeParty($authUser);
		//$this->authorize('confirmMatch', $user);

		/** @var \App\Services\Matching\Matching $matchingService */
		$matchingService = app()->make(\App\Services\Matching\Matching::class);

		if ($matchingService->accept($match->match_id, $authUser) !== true) {
			flash('Unable to confirm match')->error();

			return redirect()->back();
		}
		
        $this->confirmMatchRequestEmail($user);
		try{
			(new TwilioService())->sendMatchAcceptedNotification($authUser, $user);
		}catch(Exception $e){
                          
		}

		flash('You have successfully matched with '.$user->full_name())->success();

		event(new NewMatchSuccess($match->user1, $match->user2));

		return redirect()->back();
	}

	/**
	 * Remove a match with a user
	 *
	 * @param User $user
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function removeMatch(Match $match)
	{
		$authUser = $this->auth->user();
		$user = $match->getOppositeParty($authUser);
		//$this->authorize('removeMatch', $user);

		/** @var \App\Services\Matching\Matching $matchingService */
		$matchingService = app()->make(\App\Services\Matching\Matching::class);

		if ($matchingService->remove($match->match_id, $authUser) !== true) {
			flash('Unable to remove match')->error();

			return redirect()->back();
		}

		flash('Successfully removed the match')->success();

		return redirect()->back();
	}

	/**
	 * Reject a match with a user
	 *
	 * @param User $user
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function rejectMatch(Match $match)
	{
		$authUser = $this->auth->user();
		$user = $match->getOppositeParty($authUser);
		//$this->authorize('removeMatch', $user);

		/** @var \App\Services\Matching\Matching $matchingService */
		$matchingService = app()->make(\App\Services\Matching\Matching::class);

		if ($matchingService->reject($match->match_id, $authUser) !== true) {
			flash('Unable to remove match')->error();

			return redirect()->back();
		}

		flash('Successfully removed the match')->success();

		return redirect()->back();
	}

	/**
	 * Renew a match with a user
	 *
	 * @param User $user
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function requestRenewMatch(User $user)
	{
	//	$this->authorize('renewMatch', $user);

	    $authUser = $this->auth->user();

		$match = Match::findForUsers($authUser, $user, true);

		$renewal = $match->requestRenewal($authUser);

		if ($renewal === false) {
			flash('Unable to create the match renewal request')->error();

			return redirect()->back();
		}
		
		$this->renewMatchRequestEmail($user);

		flash('Successfully create the match renewal request')->success();

		event(new Renew($match, $user));

		return redirect()->back();
	}

	/**
	 * Confirm renew match action
	 *
	 * @param $matchId
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function confirmRenewMatch($matchId)
	{
		$match = Match::withTrashed()->find($matchId);
		$authUser = $this->auth->user();
		$user = $match->getOppositeParty($authUser);

	//	$this->authorize('acceptRenewMatch', $user);

		$matchRenewal = $match->renewal;

		$newMatch = $matchRenewal->accept($authUser);

		if (!$newMatch) {
			flash('Unable to accept match')->warning();
		} else {
		     $this->confirmRenewMatchRequestEmail($user);
			flash('Successfully renewed match')->success();
			event(new RenewSuccess($authUser, $user));
		}

		return redirect()->back();
	}

	/**
	 * reject renew match action
	 *
	 * @param $matchId
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function rejectRenewMatch($matchId)
	{
		$match = Match::withTrashed()->find($matchId);
		$authUser = $this->auth->user();
		$user = $match->getOppositeParty($authUser);

	//	$this->authorize('rejectRenewMatch', $user);

		$matchRenewal = $match->renewal;

		$matchRenewal->reject($authUser);

		flash('You rejected the match renewal')->success();

		return redirect()->back();
	}
}
