<?php
namespace API\Exceptions\Token;


use API\Exceptions\ApiException;
use Illuminate\Http\Response;

class TokenMissingException extends ApiException
{
	protected $statusCode = Response::HTTP_BAD_REQUEST;
}