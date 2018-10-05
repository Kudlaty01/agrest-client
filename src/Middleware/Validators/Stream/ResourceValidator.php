<?php

namespace Qdt01\AgRest\Middleware\Validators\Stream;

/**
 * Class ResourceValidator
 *
 * @package \Qdt01\AgRest\Middleware\Validators\Stream
 */
class ResourceValidator implements ResourceValidatorInterface
{

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public function validate($value): void
	{
		if (!is_resource($value) || 'stream' !== get_resource_type($value)) {
			throw new Exception\InvalidArgumentException(
				'Invalid stream provided; must be a stream resource'
			);
		}
	}
}