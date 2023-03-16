<?php
/**
 * Created by PhpStorm.
 * User: jeremycloutier
 * Date: 7/20/17
 * Time: 11:28 AM
 */

namespace API\Exceptions\Token;

use API\Exceptions\ApiException;
use Illuminate\Http\Response;

class TokenExpiredException extends ApiException
{
	protected $statusCode = Response::HTTP_UNAUTHORIZED;
}