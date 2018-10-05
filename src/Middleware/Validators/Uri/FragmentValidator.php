<?php

namespace Qdt01\AgRest\Middleware\Validators\Uri;

/**
 * Class FragmentValidator
 *
 * @package \Qdt01\AgRest\Middleware\Filters\Uri
 */
class FragmentValidator implements FragmentValidatorInterface
{

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public function validate($value): void
	{
		if (!is_string($value)) {
			throw new Exception\InvalidArgumentException(sprintf(
				'string argument is expected; received %s',
				is_object($value) ? get_class($value) : gettype($value)
			));
		}
	}
}