<?php

namespace Qdt01\AgRest\Middleware\Validators\Uri;

/**
 * Class SchemeValidator
 *
 * @package \Qdt01\AgRest\Validators
 */
class SchemeValidator implements SchemeValidatorInterface
{

	/**
	 * @param string $scheme explicit type declaration is omitted due to silent conversion being made
	 * @throws \InvalidArgumentException
	 */
	public function validate($scheme): void
	{
		if (!is_string($scheme)) {
			throw new \InvalidArgumentException(sprintf(
				'string argument expected for schema; received %s',
				is_object($scheme) ? get_class($scheme) : gettype($scheme)
			));
		}
	}

}