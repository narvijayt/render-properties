<?php

namespace API\Exceptions\Validation;


use Illuminate\Http\Response;

class QueryValidationException extends ValidationException
{
	protected $statusCode = Response::HTTP_BAD_REQUEST;

	protected $message = 'Invalid query parameters.';
}