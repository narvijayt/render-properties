<?php
namespace App;


use Illuminate\Database\Eloquent\Builder;

interface ISecurable
{
    /**
     * Define a scope query by which the query only returns entities that
     * the user should be able to see.
     *
     * @param Builder $query
     * @param User $user
     * @return mixed
     */
    public function scopeSecure(Builder $query, User $user) : Builder;

    /**
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public function securityQuery(Builder $query, User $user) : Builder;
}