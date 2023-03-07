<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Conversation extends Model implements ISecurable
{
    use SoftDeletes, Securable;

	const PKEY = 'conversation_id';
	protected $primaryKey = self::PKEY;

	protected $fillable = [
	    'user_id',
        'conversation_title',

    ];
    protected $casts = [
        'user_id' => 'int',
    ];

	protected $dates = [
	    'deleted_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function user() {
		return $this->belongsTo(User::class, User::PKEY);
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function messages() {
		return $this->hasMany(Message::class, $this->primaryKey);
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany;
     */
	public function subscribers() {
		return $this->belongsToMany(User::class, 'conversation_user', $this->primaryKey, User::PKEY)->withPivot('archived', 'last_read');
	}

    /**
     * Scope a query to only include un-archived conversations for a specific user.
     *
     * @param User $user
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
	public function scopeUnArchived(Builder $query, User $user)
    {
        if ($user->isNot('owner', 'admin')) {
            return $this->scopeByUser($query, $user)
                ->whereNull('conversation_user.archived');
        }

        return $query;
    }

    /**
     * Scope a query to only include archived conversations for a specific user.
     *
     * @param User $user
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeArchived(Builder $query, User $user)
    {
        if ($user->isNot('owner', 'admin')) {
            return $this->scopeByUser($query, $user)
                ->whereNotNull('conversation_user.archived');
        }

        return $query;
    }

    /**
     * Scope a query to only include conversations for a specific user.
     *
     * @param User $user
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser(Builder $query, User $user)
    {
        if ($user->isNot('owner', 'admin')) {
            $query
                ->join('conversation_user', 'conversation_user.conversation_id', '=', 'conversations.conversation_id')
                ->where('conversation_user.user_id', $user->user_id)
                ->select('conversations.*');
        }

        return $query;
    }

    /**
     * Apply user security the model
     *
     * @param Builder $query
     * @param User $user
     * @return $this
     */
    public function securityQuery(Builder $query, User $user) : Builder
    {
        return $query
            ->join('conversation_user', 'conversation_user.conversation_id', '=', 'conversations.conversation_id')
            ->where('conversation_user.user_id', $user->user_id)
            ->select('conversations.*');
    }

    /********************************************
     * Helper methods for managing a conversation
     ********************************************/

    /**
     * Update the last read time for a user
     *
     * @param User $user
     * @return int
     */
    public function updateLastRead(User $user) : int
    {
        return $this->subscribers()
            ->updateExistingPivot($user->user_id, [
                'last_read' => Carbon::now(),
            ]);
    }

    /**
     * Archive the conversation for the given user
     *
     * @param User $user
     * @return int
     */
    public function archive(User $user) : int
    {
        return $this->subscribers()
            ->updateExistingPivot($user->user_id, [
                'archived' => Carbon::now(),
            ]);
    }

    /**
     * Un-archive the conversation for the given user
     *
     * @param User $user
     * @return int
     */
    public function unArchive(User $user) : int
    {
        return $this->subscribers()
            ->updateExistingPivot($user->user_id, [
                'archived' => null,
            ]);
    }

    /**
     * Add a subscriber to the conversation
     *
     * @param User $user
     * @return Conversation
     */
    public function addSubscriber(User $user) : Conversation
    {
        $this->subscribers()
            ->attach($user, [
            	'last_read' => Carbon::now(),
			]);

        return $this;
    }

    /**
     * Add a message to the conversation
     *
     * @param User $user
     * @param $messageText
     * @return Conversation
     */
    public function addMessage(User $user, $messageText) : Conversation
    {
        $this->messages()
            ->create([
                'conversation_id' => $this->conversation_id,
                'user_id' => $user->user_id,
                'message_text' => $messageText,
            ]);

        return $this;
    }
}
