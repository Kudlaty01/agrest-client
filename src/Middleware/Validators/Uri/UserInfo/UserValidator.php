<?php

namespace Qdt01\AgRest\Middleware\Validators\Uri\UserInfo;

/**
 * Class UserValidator
 *
 * @package \Qdt01\AgRest\Middleware\Validators\Uri\UserInfo
 */
class UserValidator implements UserValidatorInterface
{

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public function validate($value): void
	{
		if (!is_string($value)) {
			throw new \InvalidArgumentException(sprintf(
				'String argument expected for user; received %s',
				is_object($value) ? get_class($value) : gettype($value)
			));
		}
	}
}