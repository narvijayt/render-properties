<?php

namespace API\Transformers;

use API\Exceptions\Validation\ValidationException;
use League\Fractal\TransformerAbstract;

class ValidationExceptionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(ValidationException $exception)
    {
        return $exception->getErrors()->messages();
    }
}
