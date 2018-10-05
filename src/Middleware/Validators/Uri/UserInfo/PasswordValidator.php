<?php

namespace Qdt01\AgRest\Middleware\Validators\Uri\UserInfo;

/**
 * Class PasswordValidator
 *
 * @package \Qdt01\AgRest\Middleware\Validators\Uri\UserInfo
 */
class PasswordValidator implements PasswordValidatorInterface
{

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public function validate($value): void
	{
		if (null !== $value && !is_string($value)) {
			throw new \InvalidArgumentException(sprintf(
				'String or null argument expected for password; received %s',
				is_object($value) ? get_class($value) : gettype($value)
			));
		}
	}
}