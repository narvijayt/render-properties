<?php

namespace API\Http\Controllers\UserDetails;

use API\Http\Controllers\Controller;
use API\Http\Requests\UserDetails\CreateRequest;
use API\Http\Requests\UserDetails\UpdateRequest;
use API\Transformers\UserDetailTransformer;
use App\UserDetail;
use Illuminate\Http\Response;


class UserDetailsController extends Controller
{
    protected $resourceClass = UserDetail::class;
    protected $transformerClass = UserDetailTransformer::class;

    /**
     * Index action
     *
     * @return \Illuminate\Http\JsonResponse
     */
	public function index()
	{
	    $user = $this->auth->user();

		$userDetails = $this->model()
            ->secure($user)
            ->get();

		return $this->createCollectionResponse($userDetails)
            ->respond();
	}

    /**
     * Store action
     *
     * @param CreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
	public function store(CreateRequest $request)
	{
		$userDetail = $this->model()
			->create($request->only([
				'user_id',
                'dob',
                'city',
                'state',
                'zip',
				'bio',
				'register',
            ]));

		return $this->createItemResponse($userDetail)
            ->respond(Response::HTTP_CREATED);
	}

    /**
     * Show action
     *
     * @param UserDetail $userDetail
     * @return \Illuminate\Http\JsonResponse
     */
	public function show(UserDetail $userDetail)
	{
//        $this->authorize('view', $userDetail);
		return $this->createItemResponse($userDetail)
            ->respond();
	}

    /**
     * Update action
     *
     * @param UpdateRequest $request
     * @param UserDetail $userDetail
     * @return \Illuminate\Http\JsonResponse
     */
	public function update(UpdateRequest $request, UserDetail $userDetail)
	{
		$userDetail->update($request->only([
			'dob',
			'city',
			'state',
			'zip',
			'bio',
			'register',
        ]));

		return $this->createItemResponse($userDetail)
            ->respond();
	}

    /**
     * destroy action
     *
     * @param UserDetail $userDetail
     * @return \Illuminate\Http\JsonResponse
     */
	public function destroy(UserDetail $userDetail)
	{
		$result = $userDetail->delete();

		return response()->json([
		    'data' => [
                'message' => 'User deleted.',
                'deleted' => $result,
            ],
		]);
	}
}
