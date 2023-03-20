<?php

namespace API\Http\Controllers\Conversations;

use API\Http\Controllers\Controller;
use API\Http\Requests\Conversations\CreateRequest;
use API\Http\Requests\Conversations\UpdateRequest;
use API\Transformers\ConversationTransformer;
use App\Conversation;
use App\Events\Conversation\NewConversation;
use App\Events\Conversation\NewMessageNotifyUser;
use Mail;
use App\Mail\ConversationNotificationEmail;
use App\Http\Requests;
use App\User;
use Illuminate\Http\Response;
use App\Events\Conversation\NewMessage;
use App\Services\TwilioService;

class ConversationsController extends Controller
{
    protected $resourceClass = Conversation::class;
    protected $transformerClass = ConversationTransformer::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->auth->user();

        $conversations = $this->model()
            ->secure($user)
            ->get()
            ->load('subscribers', 'messages', 'messages.user', 'user', 'user.avatars');

        return $this->createCollectionResponse($conversations)
            ->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
    	$currentUser = $this->auth->user();

    	$recipient = $this->model(User::class)->findOrFail($request->get('recipient'));
        /** @var Conversation $conversation */
        $conversation = $this->model()
            ->create([
            	'conversation_title' => $request->get('conversation_title'),
				'user_id' => $currentUser->user_id,
			]);
		    $conversation->addSubscriber($currentUser);
            $conversation->addSubscriber($recipient);
            $conversation->addMessage($currentUser, $request->get('message'));
            $conversation->subscribers->each(function($subscriber) use ($conversation) {
			broadcast(new NewConversation($subscriber, $conversation));
		});
		broadcast(new NewMessage($conversation->messages->first()));
			/*****************Mail To receiver*******************/
			$user['sender_email']  = $currentUser->email;
			$user['receiver_email'] = $recipient->email;
		    $user['sender_first_name'] = ucfirst($currentUser->first_name);
			$user['receiver_first_name'] = ucfirst($recipient->first_name);
			$user['conv_title'] = $request->get('conversation_title');
			$user['conv_message'] = $request->get('message');
		    $email = new ConversationNotificationEmail($user);
		     try{
                Mail::to($user['receiver_email'])->send($email);
                $conversationData['currentUser'] = $currentUser;
                $conversationData['recipient'] = $recipient;
                (new TwilioService())->sendConversationNotificationSMS($conversationData);
                $this->info('Conversation mail has been succesfully sent to: '.$user['receiver_email']);
            }
            catch(\Exception $e) {
                \Log::error("Failed sending Email : " . $e->getMessage());
                return ;
            }
           /****************End Sending Mail To Receiver*******/
           
		return $this->createItemResponse($conversation)
            ->respond(Response::HTTP_CREATED);
    }


    /**
     * Display the specified resource.
     *
     * @param  Conversation $conversation
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        return $this->createItemResponse($conversation)
            ->respond();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest $request
     * @param  Conversation  $conversation
     *
     * @return Response
     */
    public function update(UpdateRequest $request, Conversation $conversation)
    {
        $conversation->update($request->only([
            'conversation_title',
        ]));

        return $this->createItemResponse($conversation)
            ->respond();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation)
    {
        $result = $conversation->delete();

        return response()->json([
            'data' => [
                'message' => 'Conversation deleted.',
                'deleted' => $result,
            ]
        ], Response::HTTP_OK);
    }
}
