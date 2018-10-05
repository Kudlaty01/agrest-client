<?php

namespace Qdt01\AgRest\Middleware\Validators\Message;

/**
 * Class HeaderNameValidator
 *
 * @package \Qdt01\AgRest\Middleware\Validators\Message
 */
class HeaderNameValidator implements HeaderNameValidatorInterface
{
	/**
	 * explicit parameter type definition is omitted to avoid silent conversion
	 *
	 * @see http://tools.ietf.org/html/rfc7230#section-3.2
	 * @param string $value
	 * @throws \InvalidArgumentException
	 */
	public function validate($value): void
	{
		if (!is_string($value)) {
			throw new \InvalidArgumentException(sprintf(
				'Invalid header name type; expected string; received %s',
				(is_object($value) ? get_class($value) : gettype($value))
			));
		}
		if (!preg_match('/^[a-zA-Z0-9\'`#$%&*+.^_|~!-]+$/', $value)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" is not valid header name',
				$value
			));
		}
	}
}