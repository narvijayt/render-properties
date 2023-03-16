<?php
namespace API\Exceptions\Token;


use API\Exceptions\ApiException;
use Illuminate\Http\Response;

class TokenInvalidException extends ApiException
{
	protected $statusCode = Response::HTTP_UNAUTHORIZED;
}