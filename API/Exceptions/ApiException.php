<?php

namespace API\Exceptions;

use API\Transformers\ExceptionTransformer;
use Illuminate\Http\Response;

class ApiException extends \Exception implements IJSONException
{
	/**
	 * Exception status code
	 *
	 * @var int
	 */
	protected $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

	protected $transformer = ExceptionTransformer::class;

	/**
	 * Constructor
	 *
	 * @param string $message
	 * @param null $statusCode
	 */
	public function construct($message = 'An Error Occured', $statusCode = null)
	{
		parent::__construct($message, $statusCode);

		if (! is_null($statusCode)) {
			$this->statusCode($statusCode);
		}
	}

	/**
	 * Set the status code
	 *
	 * @param int $statusCode
	 * @return $this
	 */
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;

		return $this;
	}

	/**
	 * Get the exception status code
	 *
	 * @return int
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * Serialize the exception
	 *
	 * @return array
	 */
	public function serialize()
	{
		return fractal()
			->item($this, new $this->transformer, 'errors')
			->addMeta([
				'code' => $this->statusCode,
				'message' => $this->getMessage(),
				'type' => class_basename($this),
			])
			->toArray();
	}

	/**
	 * Create json response
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function respond()
	{
		return response()->json($this->serialize(), $this->statusCode);
	}
}