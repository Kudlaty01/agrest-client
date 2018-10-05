<?php

namespace Qdt01\AgRest\Middleware\Validators\Uri;

/**
 * Class PortValidator
 *
 * @package \Qdt01\AgRest\Middleware\Filters\Uri
 */
class PortValidator implements PortValidatorInterface
{

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public function validate($value): void
	{
		if ($value !== null) {
			if (!is_numeric($value) || is_float($value)) {
				throw new \InvalidArgumentException(sprintf(
					'Invalid port "%s" specified; must be an integer, an integer string, or null',
					is_object($value) ? get_class($value) : gettype($value)
				));
			}
			if ($value < 1 || $value > 65535) {
				throw new \InvalidArgumentException(sprintf(
					'Invalid port "%d" specified; must be a valid TCP/UDP port',
					$value
				));
			}
		}

	}
}