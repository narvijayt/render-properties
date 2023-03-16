<?php

namespace API\Http\Controllers\Conversations\Reads;

use API\Http\Controllers\Controller;
use App\Conversation;
use App\Http\Requests;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ReadsController extends Controller
{
	protected $resourceClass = Conversation::class;

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

		return $this->createArrayItemResponse([
				'last_read' => $subscriber->pivot->last_read,
			])
			->respond();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Conversation $conversation
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Conversation $conversation, $id)
	{
		$this->authorize('view', $conversation);
		$subscriber = $conversation->subscribers->find($id);

		if ($subscriber === null) {
			throw new NotFoundHttpException('The conversation does not have a subscriber with that id');
		}

		$conversation->updateLastRead($subscriber);
		$conversation->load(['subscribers']);
		$subscriber = $conversation->subscribers->find($id);

		return $this->createArrayItemResponse([
				'last_read' => $subscriber->pivot->last_read
			])
			->respond();
	}
}
