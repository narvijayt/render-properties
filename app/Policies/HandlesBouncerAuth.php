<?php
/**
 * Created by PhpStorm.
 * User: jeremycloutier
 * Date: 7/27/17
 * Time: 10:53 AM
 */

namespace App\Policies;

use Illuminate\Auth\AuthManager;
use Illuminate\Database\Eloquent\Model;
use Silber\Bouncer\Bouncer;
use Illuminate\Contracts\Auth\Guard;
use App\User;

trait HandlesBouncerAuth
{
    /**
     * @var Guard
     */
    protected $auth;

    /**
     * @var Bouncer
     */
    protected $bouncer;

    /**
     * @var string
     */
    protected $policyModel;

    /**
     * HandlesBouncerAuth constructor.
     *
     * @param Guard $auth
     * @param Bouncer $bouncer
     */
    public function __construct(Guard $auth, Bouncer $bouncer)
    {
        $this->auth = $auth;
        $this->bouncer = $bouncer;

        $this->policyModel = $this->policyModel();
    }

    /**
     * Check if the user is an owner and if so grant all
     *
     * @param User $user
     * @param $ability
     * @return bool
     */
//    public function before(User $user, $ability)
//    {
//        if ($user->isAn('owner')) {
//            return true;
//        }
//    }

    /**
     * Return the Fully Qualified namespace for the policies class model
     * eg. User::class
     *
     * @return string
     */
    abstract protected function policyModel() : string;

    /**
     * Normalize the model name from studly case to kebab case singular
     *
     * @return string
     */
    protected function normalizeModelName() : string
    {
        return kebab_case(str_singular(class_basename($this->policyModel)));
    }

    /**
     * Convert the ability in to the form that bouncer expects for a given model.
     * eg. view BrokerSale = broker-sale:view
     *
     * @param string $ability
     * @return string
     */
    protected function bouncerAbility(string $ability) : string
    {
        $prefix = $this->normalizeModelName();

        return "${prefix}:${ability}";
    }

    /**
     * Check if the currently logged in user is guest
     *
     * @return bool
     */
    protected function isGuest() : bool
    {
        return $this->auth->guest();
    }

    /**
     * Check if the currently logged in user is authenticated.
     *
     * @return bool
     */
    protected function isLoggedIn() : bool
    {
        return $this->auth->check();
    }

    /**
     * Check if the currently logged in user is the user being authorized
     *
     * @param User $user
     * @return bool
     */
    protected function isSelf(User $user) : bool
    {
        return (
            $user->user_id === $this->auth->user()->user_id
        );
    }

    /**
     * @param string $ability
     * @param \Illuminate\Database\Eloquent\Model|string|null $entity
     * @return bool
     */
    protected function bounce(string $ability, $entity = null) : bool
    {
        if ( $entity instanceof Model ) {
            return $this->bouncer->allows($this->bouncerAbility($ability), $entity);
        } else if ( is_string($entity) ) {
            return $this->bouncer->allows($this->bouncerAbility($ability), $this->policyModel);
        }

        return $this->bouncer->allows($ability);
    }

    /**
     * Determine whether the user can list all entities
     *
     * @param  User  $user
     * @return boolean
     */
    public function index(User $user) : bool
    {
        return $this->bounce('index', $this->policyModel);
    }

    /**
     * Determine whether the user can view the entity
     *
     * @param  User  $user
     * @param  Model  $entity
     * @return boolean
     */
    public function view(User $user, Model $entity) : bool
    {
        return $this->bounce('view', $entity);
    }

    /**
     * Determine whether the user can create an entity
     *
     * @param  User  $user
     * @return boolean
     */
    public function create(User $user) : bool
    {
        return $this->bounce('create', $this->policyModel);
    }

    /**
     * Determine whether the user can update an entity
     *
     * @param  User  $user
     * @param  Model  $entity
     * @return boolean
     */
    public function edit(User $user, Model $entity) : bool
    {
        return $this->bounce('edit', $entity);
    }

    /**
     * Determine whether the user can delete an entity
     *
     * @param  User  $user
     * @param  Model  $entity
     * @return boolean
     */
    public function delete(User $user, Model $entity) : bool
    {
        return $this->bounce('delete', $entity);
    }
}