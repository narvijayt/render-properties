<?php
/**
 * Created by PhpStorm.
 * User: jeremycloutier
 * Date: 7/31/17
 * Time: 11:30 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Builder;

trait Securable
{

    /**
     * Add a security query to model
     *
     * @param Builder $query
     * @param User $model
     * @return Builder
     */
    public function scopeSecure(Builder $query, User $user) : Builder
    {

        if ($user->isNotA('admin', 'owner')) {
            return $this->securityQuery($query, $user);
        }

        return $query;
    }

    /**
     * Security query for model
     *
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public abstract function securityQuery(Builder $query, User $user) : Builder;
}