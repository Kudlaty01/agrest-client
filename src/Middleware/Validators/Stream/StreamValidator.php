<?php

namespace Qdt01\AgRest\Middleware\Validators\Stream;


/**
 * Class StreamValidator
 *
 * @package \Qdt01\AgRest\Middleware\Validators
 */
class StreamValidator implements StreamValidatorInterface
{

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public function validate($value): void
	{
		if (is_resource($value) || is_string($value)) {
			throw new \InvalidArgumentException(sprintf('Invalid resource. Expected resource type or string, got %s',
				is_object($value) ? get_class($value) : gettype($value)
			));
		}
	}
}