<?php

namespace API\Transformers;

use League\Fractal\TransformerAbstract;

class ExceptionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(\Exception $exception)
    {
        return [
			'message' => $exception->getMessage(),
        ];
    }
}
