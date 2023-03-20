<?php

namespace API\Http\Controllers\Conversations\Messages;

use API\Http\Controllers\Controller;
use API\Http\Requests\Messages\CreateRequest;
use API\Http\Requests\Messages\UpdateRequest;
use API\Transformers\MessageTransformer;
use App\Conversation;
use App\User;
use App\Events\Conversation\NewMessage;
use App\Events\Conversation\NewMessageNotifyUser;
use App\Message;
use Mail;
use App\Mail\ConversationNotificationEmail;
use App\ConversationUser;
use Illuminate\Http\Response;
use App\Services\TwilioService;

class MessagesController extends Controller
{
    protected $resourceClass = Message::class;
    protected $transformerClass = MessageTransformer::class;

    /**
     * Index action
     *
     * @param Conversation $conversation
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Conversation $conversation)
    {
        $this->authorize('view', $conversation); // verify that the user can view the conversation

        $user = $this->auth->user();

        $messages = $this->model()
            ->secure($user)
            ->forConversation($conversation)
            ->get()
            ->load('conversation', 'user');

        return $this->createCollectionResponse($messages)
            ->respond();
    }

    /**
     * Store action
     *
     * @param CreateRequest $request
     * @param Conversation $conversation
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request, Conversation $conversation)
    {
      //  $this->authorize('create-message', $conversation);

        $data = [
            'conversation_id'   => $conversation->conversation_id,
            'user_id'           => $this->auth->user()->user_id,
            'message_text'      => $request->get('message_text'),
        ];
        /** @var Message $message */
        $message = $this->model()
            ->create($data);
		$message->conversation()->touch();

		$conversation->subscribers->each(function($sub) use ($message) {
			broadcast(new NewMessageNotifyUser($message, $sub));
		});

        broadcast(new NewMessage($message));
        $findAuthUser = User::find($this->auth->user()->user_id);
        $getReceiver = ConversationUser::where('user_id','!=',$this->auth->user()->user_id)->find($conversation->conversation_id);
        if($findAuthUser !="" && $getReceiver !="")
        {
            $receiver  = User::find($getReceiver->user_id);
            $user['sender_email'] = $findAuthUser->email;
            $user['sender_first_name'] = ucfirst($findAuthUser->first_name);
            $user['receiver_email'] = $receiver->email;
            $user['receiver_first_name'] = ucfirst($receiver->first_name);
            $user['conv_title'] = $conversation->conversation_title;
    		$user['conv_message'] = $request->get('message_text');
            $email = new ConversationNotificationEmail($user);
		     try{
                Mail::to($user['receiver_email'])->send($email);
                $this->info('Conversation mail has been succesfully sent to: '.$user['receiver_email']);
                $conversationData['currentUser'] = $currentUser;
                $conversationData['recipient'] = $recipient;
                (new TwilioService())->sendConversationNotificationSMS($conversationData);
            }
            catch(\Exception $e) {
                \Log::error("Failed sending Email : " . $e->getMessage());
                return ;
            }
        }
        /****************End Sending Mail To Receiver*******/
        return $this->createItemResponse($message)
            ->respond(Response::HTTP_CREATED);
    }

    /**
     * Show action
     *
     * @param Conversation $conversation
     * @param Message $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Conversation $conversation, Message $message)
    {
        return $this->createItemResponse($message)
            ->respond();
    }

    /**
     * Update action
     *
     * @param UpdateRequest $request
     * @param Conversation $conversation
     * @param Message $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Conversation $conversation, Message $message)
    {
        $message->update($request->only([
            'message_text',
        ]));

        return $this->createItemResponse($message)
            ->respond();
    }

    public function destroy(Conversation $conversation, Message $message)
    {
        $result = $message->delete();

        return response()->json([
            'data' => [
                'message' => 'Message deleted.',
                'deleted' => $result,
            ]
        ], Response::HTTP_OK);
    }

}
