<?php
namespace App\Services\Conversations;


use App\Conversation as ConversationModel;
use App\Message;
use App\User;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Conversation service for managing and creating conversations & messages
 *
 * @author Jeremy Cloutier <jeremy.cloutier@radixbay.com>
 * @package App\Services\Conversations
 */
class Conversation
{
    /**
     * @var \App\Conversation
     */
    protected $conversation;

    /**
     * @var \App\Message
     */
    protected $message;

    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var Carbon
     */
    protected $carbon;

    /**
     * Conversation constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container, ConversationModel $conversation, Message $message, Carbon $carbon)
    {
        $this->container = $container;
        $this->conversation = $conversation;
        $this->message = $message;
        $this->carbon = $carbon;
    }

    /**
     * Returns the conversation model
     *
     * @return \App\Conversation
     */
    public function conversation() : ConversationModel
    {
        return $this->conversation;
    }

    /**
     * Create a new conversation
     *
     * @param User $user
     * @param string $title
     * @return Conversation
     */
    public function create(User $user, string $title) : Conversation
    {
        $this->conversation = $this->resetConversationModel()
            ->conversation
            ->create([
                'user_id' => $user->user_id,
                'conversation_title' => $title,
            ]);

        $this->addSubscriber($user);

        return $this;
    }

    /**
     * Create a new instance of the conversation model
     *
     * @return Conversation
     */
    protected function resetConversationModel() : Conversation
    {
        $this->conversation = $this->refreshModel($this->conversation);

        return $this;
    }

    /**
     * Reset a model instance
     *
     * @param Model $model
     * @return Model
     */
    protected function refreshModel(Model $model) : Model
    {
        $class = get_class($this->conversation);

        return $this->container->make($class);
    }

    /**
     * Add a subscriber to the conversation
     *
     * @param User $user
     * @return Conversation
     */
    public function addSubscriber(User $user) : Conversation
    {
        $this->conversation
            ->subscribers()
            ->attach($user);

        return $this;
    }

    public function addMessage(User $user, $messageText) : Conversation
    {
        $this->resetMessageModel()
            ->message
            ->create([
                'conversation_id' => $this->conversation->conversation_id,
                'user_id' => $user->user_id,
                'message_text' => $messageText,
            ]);

        return $this;
    }

    /**
     * Create a new instance of the message model
     *
     * @return Conversation
     */
    protected function resetMessageModel() : Conversation
    {
        $this->messageClass = $this->refreshModel($this->message);

        return $this;
    }

    /**
     * Find an existing conversation
     *
     * @param int $id
     * @return Conversation
     */
    public function find(int $id) : Conversation
    {
        $this->conversation = $this->conversation->findOrFail($id);

        return $this;
    }

    /**
     * Get the message for the conversation
     *
     * @param string $orderBy
     * @param string $direction
     * @return Collection
     */
    public function messages($orderBy = 'created_at', $direction = 'asc') : Collection
    {
        return $this->conversation
            ->messages()
            ->orderBy($orderBy, $direction)
            ->get();
    }

    /**
     * Get the subscribers for the conversation
     *
     * @return Collection
     */
    public function subscribers() : Collection
    {
        return $this->conversation
            ->subscribers;
    }

    /**
     * Update the last read time for a user
     *
     * @param User $user
     * @return Conversation
     */
    public function read(User $user) : Conversation
    {
        $this->updateSubscriberPivot($user, [
            'last_read' => $this->carbon->now(),
        ]);

        return $this;
    }

    /**
     * Update the subscriber pivot table
     *
     * @param User $user
     * @param array $attributes
     * @return int
     */
    protected function updateSubscriberPivot(User $user, array $attributes) : int
    {
        return $this->conversation
            ->subscribers()
            ->updateExistingPivot($user->user_id, $attributes);
    }

    /**
     * Archive the conversation for the current user
     *
     * @param User $user
     * @return Conversation
     */
    public function archive(User $user) : Conversation
    {
        $this->updateSubscriberPivot($user, [
            'archived' => $this->carbon->now(),
        ]);

        return $this;
    }

    /**
     * Un-Archive the conversation for the current user
     *
     * @param User $user
     * @return Conversation
     */
    public function unArchive(User $user) : Conversation
    {
        $this->updateSubscriberPivot($user->user_id, [
            'archived' => null,
        ]);

        return $this;
    }

    /**
     * Get all un archived conversations for a user
     *
     * @param User $user
     * @return Collection
     */
    public function unArchived(User $user) : Collection
    {
        return $this->resetConversationModel()
            ->conversation
            ->unArchived($user)
            ->get();
    }

    /**
     * Get all archived conversations for a user
     *
     * @param User $user
     * @return Collection
     */
    public function archived(User $user) : Collection
    {
        return $this->resetConversationModel()
            ->conversation
            ->archived($user)
            ->get();
    }

    /**
     * Get all conversations for a user
     *
     * @param User $user
     * @return Collection
     */
    public function all(User $user) : Collection
    {
        return $this->resetConversationModel()
            ->conversation
            ->byUser($user)
            ->get();
    }

    /**
     * Set the conversation object
     *
     * @param ConversationModel $conversation
     * @return Conversation
     */
    public function setConversation(ConversationModel $conversation) : Conversation
    {
        $this->conversation = $conversation;

        return $this;
    }
}