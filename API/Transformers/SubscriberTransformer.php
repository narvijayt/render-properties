<?php

namespace API\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

/**
 * Class SubscriberTransformer
 * @package namespace API\Transformers;
 */
class SubscriberTransformer extends TransformerAbstract
{
    /**
     * Transform the Subscriber entity
     * @param Subscriber $model
     *
     * @return array
     */
    public function transform(User $user)
    {
        $userTransformer = new UserTransformer();
        $transform = $userTransformer->transform($user);

        $pivotData = [
            'archived' => is_null($user->pivot->archived) ? null : (string) $user->pivot->archived,
            'last_read' => is_null($user->pivot->last_read) ? null : (string) $user->pivot->last_read,
        ];

        return array_merge($transform, $pivotData);
    }
}
