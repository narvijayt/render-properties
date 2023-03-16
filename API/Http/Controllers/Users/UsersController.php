<?php

namespace API\Http\Controllers\Users;

use API\Http\Requests\Users\CreateRequest;
use API\Http\Requests\Users\UpdateRequest;
use API\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Response;
use API\Http\Controllers\Controller;

class UsersController extends Controller
{
    protected $resourceClass = User::class;
    protected $transformerClass = UserTransformer::class;

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
            ->get();

        return $this->createCollectionResponse($conversations)
            ->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRequest   $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
		$user = $this->model()
			->create($request->only([
			    'username',
                'first_name',
                'last_name',
                'email',
                'password',
                'active',
            ]));

		return $this->createItemResponse($user)
            ->respond(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
		return $this->createItemResponse($user)
            ->respond();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest     $request
     * @param  User              $user
     *
     * @return Response
     */
    public function update(UpdateRequest $request, User $user)
    {
		$user->update($request->only([
		    'username',
            'first_name',
            'last_name',
            'email',
            'active',
        ]));

		return $this->createItemResponse($user)
            ->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $result = $user->delete();

		return response()->json([
		    'data' => [
                'message' => 'User deleted.',
                'deleted' => $result,
            ]
		]);
    }
}
