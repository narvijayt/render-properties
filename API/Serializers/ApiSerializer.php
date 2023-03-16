<?php
/**
 * Created by PhpStorm.
 * User: jeremycloutier
 * Date: 7/20/17
 * Time: 9:25 AM
 */

namespace API\Serializers;

use League\Fractal\Serializer\DataArraySerializer;

class ApiSerializer extends DataArraySerializer
{
	public function collection(?string $resourceKey, array $data): array
	{
		if ($resourceKey) {
			return [$resourceKey => $data];
		}

		return $data;
	}

	public function item(?string $resourceKey, array $data): array
	{
		if ($resourceKey) {
			return [$resourceKey => $data];
		}
		return $data;
	}
}