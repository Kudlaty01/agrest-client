<?php

namespace Qdt01\AgRest\Middleware\Validators\Request;

/**
 * Class MethodValidator
 *
 * @package \Qdt01\AgRest\Middleware\Validators\Request
 */
class MethodValidator implements MethodValidatorInterface
{
	/**
	 * @param string $method
	 * @throws \InvalidArgumentException
	 */
	public function validate($method): void
	{
		if (!is_string($method)) {
			throw new \InvalidArgumentException(sprintf(
				'Unsupported HTTP method; must be a string, received %s',
				is_object($method) ? get_class($method) : gettype($method)
			));
		}

		if (!preg_match('/^[!#$%&\'*+.^_`\|~0-9a-z-]+$/i', $method)) {
			throw new \InvalidArgumentException(sprintf(
				'Unsupported HTTP method "%s" provided',
				$method
			));
		}
	}
}