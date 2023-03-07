<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\PartialRegistration;
use Socialite;
use App\Broker;
use Ramsey\Uuid\Uuid;
use App\UserProvider;



class AuthController extends Controller
{
    protected $redirectTo = '/home';

    /**
     * Sends a user to their Oauth Provider
     * @param $provider
     * @return mixed
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();

        $authUser = $this->fetchAuthUser($user, $provider);

        if($authUser === false) {
            return $this->findOrCreatePartailRegistration($user, $provider);

        }
        else {
            $realUser= User::find($authUser->user_id);
            Auth::login($realUser, true);
        }
        return redirect($this->redirectTo);
    }

    /**
     * Checks for existing user with given provider
     *
     * @param $user
     * @param $provider
     * @return bool
     */
    public function fetchAuthUser($user, $provider)
    {
        $authUser = UserProvider::where(['provider_id' => $user->id, 'provider' => $provider])->first();

        return (
            $authUser === null
                ? false
                : $authUser
        );
    }

    /**
     * If a user has Partially Registered before
     * else, create a new partial registration object as
     * insurance if they do not finish we can still email them..
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreatePartailRegistration($user, $provider)
    {
        
    	$email = strtolower($user->email);
        $previous = PartialRegistration::where([
                'email' => $email,
                'provider' => $provider,
                'deleted_at' => null
            ])->first();
        if($previous !== null){
            return redirect()->route('register', ['remember_token' => $previous->remember_token]);
        }
        else {
            $parts = explode(" ", $user->name);
            $lastname = array_pop($parts);
            $firstname = implode(" ", $parts);
            $UUID = Uuid::uuid4()->toString();
            $input = PartialRegistration::create([
                'first_name' => $firstname,
                'last_name'  => $lastname,
                'email'      => $email,
                'provider'   => $provider,
                'provider_id'=> $user->id,
                'remember_token' => $UUID,

            ]);
            return redirect()->route('register', ['remember_token' => $input->remember_token]);

        }
    }
}
