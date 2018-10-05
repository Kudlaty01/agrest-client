<?php

namespace Qdt01\AgRest\Middleware\Validators\Uri;

/**
 * Class HostValidator
 *
 * @package \Qdt01\AgRest\Middleware\Filters\Uri
 */
class HostValidator implements HostValidatorInterface
{

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public function validate($value): void
	{
		if (!is_string($value)) {
			throw new \InvalidArgumentException(sprintf(
				'String argument expected for host; received %s',
				is_object($value) ? get_class($value) : gettype($value)
			));
		}
	}
}