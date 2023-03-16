<?php

namespace API\Http\Controllers;

use API\Transformers\ArrayTransformer;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use League\Fractal\TransformerAbstract;
use Spatie\Fractal\Fractal;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Guard
     */
    protected $auth;

    /**
     * @var Fractal
     */
    protected $fractal;

    /**
     * @var string
     */
    protected $resourceClass;

    /**
     * @var string
     */
    protected $transformerClass;

    /**
     * Controller constructor.
     * @param Application $app
     * @param Guard $auth
     * @param Fractal $fractal
     */
    public function __construct(
        Application $app,
        Guard $auth,
        Fractal $fractal
    ) {
        $this->app = $app;
        $this->auth = $auth;
        $this->fractal = $fractal;

        $this->authorizeResource($this->resourceClass);
    }

    protected function resourceAbilityMap()
    {
        return [
            'index' => 'index',
            'show' => 'view',
            'create' => 'create',
            'store' => 'create',
            'edit' => 'edit',
            'update' => 'edit',
            'destroy' => 'delete',
        ];
    }

    /**
     * Create a model instance
     *
     * @param null $modelClass
     * @return Model
     */
    protected function model($modelClass = null) : Model
    {
        $model = $modelClass !== null ? $modelClass : $this->resourceClass;

        return $this->app->make($model);
    }

    /**
     * Create a transformer instance
     *
     * @return TransformerAbstract
     */
    protected function transformer($transformer = null) : TransformerAbstract
    {
    	if (!is_null($transformer)) {
    		return $this->app->make($transformer);
		}

        return $this->app->make($this->transformerClass);
    }

    /**
     * Create fractal response for collection
     *
     * @param Collection $collection
     * @return Fractal
     */
    protected function createCollectionResponse(Collection $collection) : Fractal
    {
        return $this->transformCollection($collection)
            ->transformWith($this->transformer());
    }

    /**
     * Create fractal response for single record
     *
     * @param Model $model
     * @return Fractal
     */
    protected function createItemResponse(Model $model) : Fractal
    {
        return $this->transformItem($model)
            ->transformWith($this->transformer());
    }

	/**
	 * Create a fractal response from an array
	 *
	 * @param array $data
	 * @return Fractal
	 */
    protected function createArrayItemResponse(array $data) : Fractal
	{
		return $this->transformItem($data)
			->transformWith($this->transformer(ArrayTransformer::class));
	}

	protected function createArrayResponse(array $data) : Fractal
	{
		return $this->transformCollection($data)
			->transformWith($this->transformer(ArrayTransformer::class));
	}

	/**
	 * Create a basic fractal instance without a transformer
	 *
	 * @param mixed $data
	 * @param string $key
	 * @return Fractal
	 */
	protected function transformItem($data, $key = 'data') : Fractal
	{
		return $this->fractal
			->item($data, null, $key);
	}

	protected function transformCollection($data, $key = 'data') : Fractal
	{
		return $this->fractal
			->collection($data, null, $key);
	}

    /**
     * Get the currently authenticated user
     *
     * @return User
     */
    protected function getUser() : User
    {
        return $this->auth->user();
    }
}
