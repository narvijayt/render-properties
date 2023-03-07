<?php

namespace App\Http\Controllers\Pub\MessageCenter;

use API\Transformers\ConversationTransformer;
use App\Conversation;
use Illuminate\Http\Response;
use JWTAuth;
use App\Http\Controllers\Controller;
use Spatie\Fractal\Fractal;

class MessageCenterController extends Controller
{
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		ini_set('memory_limit', -1);
		$conversations = Conversation::secure(auth()->user())
			->get()
			->load('subscribers', 'messages', 'messages.user');

		/** @var Fractal $fractal */
		$fractal = app()->make(Fractal::class);
		$transformer = app()->make(ConversationTransformer::class);

		$conversationSeed = $fractal->collection($conversations, $transformer, 'data');

		return view('pub.message-center.index', compact('conversations', 'conversationSeed'));
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function test()
	{
		return view('pub.message-center.test');
	}
}
