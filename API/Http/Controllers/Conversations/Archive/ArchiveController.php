<?php

namespace API\Http\Controllers\Conversations\Archive;

use API\Http\Controllers\Controller;
use API\Transformers\ConversationTransformer;
use App\Conversation;

class ArchiveController extends Controller
{
	protected $resourceClass = Conversation::class;
	protected $transformerClass = ConversationTransformer::class;

	/**
	 * archive action
	 *
	 * @param Conversation $conversation
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function archive(Conversation $conversation)
	{
		$this->authorize('archive', $conversation); // verify that the user can view the conversation

		$conversation->archive($this->getUser());

		$conversation->load('subscribers', 'messages', 'messages.user', 'user', 'user.avatars');

		return $this->createItemResponse($conversation)
			->respond();
	}

	/**
	 * Unarchive action
	 *
	 * @param Conversation $conversation
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function unarchive(Conversation $conversation)
	{
		$this->authorize('archive', $conversation); // verify that the user can view the conversation

		$conversation->unArchive($this->getUser());

		$conversation->load('subscribers', 'messages', 'messages.user', 'user', 'user.avatars');

		return $this->createItemResponse($conversation)
			->respond();
	}
}
