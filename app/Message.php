<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;

class Message extends Model implements ISecurable
{
    use SoftDeletes, Securable, Rememberable;

	const PKEY = 'message_id';
	protected $primaryKey = self::PKEY;

	protected $fillable = [
        'conversation_id',
        'user_id',
        'message_text',
    ];

	protected $dates = [
	    'deleted_at',
    ];

    protected $casts = [
        'conversation_id' => 'int',
        'user_id' => 'int',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function user() {
		return $this->belongsTo(User::class, User::PKEY);
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function conversation() {
		return $this->belongsTo(Conversation::class, Conversation::PKEY);
	}

    /**
     * Select all messages for a given conversation
     *
     * @param Builder $query
     * @param Conversation $conversation
     */
	public function scopeForConversation(Builder $query, Conversation $conversation)
    {
        return $query->where('messages.conversation_id', $conversation->conversation_id)
            ->orderBy('created_at', 'asc');
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
            ->join('conversations', 'conversations.conversation_id', '=', 'messages.conversation_id')
            ->join('conversation_user', 'conversation_user.conversation_id', '=', 'conversations.conversation_id')
            ->where('conversation_user.user_id', $user->user_id)
            ->select('messages.*');
    }
}
