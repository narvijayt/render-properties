<?php
namespace API\Exceptions\Token;


use API\Exceptions\ApiException;
use Illuminate\Http\Response;

class TokenInvalidUserException extends ApiException
{
	protected $statusCode = Response::HTTP_NOT_FOUND;
}