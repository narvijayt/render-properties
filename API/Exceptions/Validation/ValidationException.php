<?php

namespace API\Exceptions\Validation;

use API\Exceptions\ApiException;
use API\Transformers\ValidationExceptionTransformer;
use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;

class ValidationException extends ApiException
{
	protected $statusCode = Response::HTTP_BAD_REQUEST;

	protected $errors;

	protected $transformer = ValidationExceptionTransformer::class;

	protected $message = 'A validation exception has occurred';

	public function __construct(MessageBag $errors, $message = null)
	{
		$this->errors = $errors;

		if (! is_null($message)) {
			$this->message = $message;
		}

		parent::__construct($this->message);
	}

	/**
	 * @return MessageBag
	 */
	public function getErrors()
	{
		return $this->errors;
	}
}