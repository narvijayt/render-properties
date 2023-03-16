<?php

namespace API\Http\Controllers\Conversations\Subscribers;

use API\Http\Controllers\Controller;
use API\Transformers\UserTransformer;
use App\Conversation;
use App\Http\Requests;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class SubscribersController extends Controller
{
	protected $resourceClass = Conversation::class;
	protected $transformerClass = UserTransformer::class;

	/**
	 * Override ability map since it does't really pertain to this controller
	 *
	 * @return array
	 */
	protected function resourceAbilityMap()
	{
		return [];
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Conversation $conversation)
	{
		$this->authorize('view', $conversation);

		$subscribers = $conversation->subscribers;

		return $this->createCollectionResponse($subscribers)
			->respond();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Conversation $conversation
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Conversation $conversation, $id)
	{
		$this->authorize('view', $conversation);

		$subscriber = $conversation->subscribers->find($id);

		if ($subscriber === null) {
			throw new NotFoundHttpException('The conversation does not have a subscriber with that id');
		}

		return $this->createItemResponse($subscriber)
			->respond();
	}
}
