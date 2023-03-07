<?php

use Illuminate\Database\Seeder;
use App\Conversation;
use App\Message;
use Carbon\Carbon;
use App\User;
use App\Services\Conversations\Conversation as ConversationService;

class ConversationSeeder extends Seeder
{
    public function __construct(ConversationService $conversationService)
    {
        $this->conversationService = $conversationService;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $realtors = User::realtors()->get();
        $brokers = User::brokers()->get();

        $brokers
            ->shuffle()
            ->each(function(User $owner) use ($realtors) {
                /** @var Conversation $convo */
                factory(Conversation::class, mt_rand(1, 3))->create([
                    'user_id' => $owner->user_id,
                ])
                ->each(function(Conversation $convo) use ($owner, $realtors) {
                    /** @var User $contact */
                    $contact = $realtors->random();

                    $this->attachUserToConvo($convo, $owner);
                    $this->attachUserToConvo($convo, $contact);

                    $this->generateMessages($convo, [
                        $owner->user_id,
                        $contact->user_id,
                    ]);
                });
            });

        $realtors
            ->shuffle()
            ->each(function(User $owner) use ($brokers) {
                /** @var Conversation $convo */
                factory(Conversation::class, mt_rand(1, 3))->create([
                    'user_id' => $owner->user_id,
                ])->each(function(Conversation $convo) use ($owner, $brokers) {
                    /** @var User $contact */
                    $contact = $brokers->random();

                    $this->attachUserToConvo($convo, $owner);
                    $this->attachUserToConvo($convo, $contact);

                    $this->generateMessages($convo, [
                        $owner->user_id,
                        $contact->user_id,
                    ]);
                });
            });
    }

    /**
     * Generate messages for the conversation
     *
     * @param Conversation $convo
     * @param array $users
     */
    protected function generateMessages(Conversation $convo, array $users)
    {
        factory(Message::class, mt_rand(3, 30))
            ->make()
            ->each(function(Message $message) use ($convo, $users){
                $message->user_id = $users[mt_rand(0, 1)];
                $message->created_at = Carbon::now()->subHours(mt_rand(-10, 0));
                $message->conversation_id = $convo->conversation_id;
                $message->save();
            });
    }

    /**
     * Attach the user to the conversation
     *
     * @param Conversation $convo
     * @param User $user
     */
    protected function attachUserToConvo(Conversation $convo, User $user)
    {
        $convo->subscribers()->attach($user, [
            'archived' => null,
            'last_read' => Carbon::now()->subHours(mt_rand(-10, 0)),
        ]);
    }
}
