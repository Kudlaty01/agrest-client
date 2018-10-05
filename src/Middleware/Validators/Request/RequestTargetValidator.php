<?php

namespace Qdt01\AgRest\Middleware\Validators\Request;

/**
 * Class RequestTargetValidator
 *
 * @package \Qdt01\AgRest\Middleware\Validators\Request
 */
class RequestTargetValidator implements RequestTargetValidatorInterface
{

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public function validate($value): void
	{
		if (preg_match('#\s#', $value)) {
			throw new \InvalidArgumentException(
				'Invalid request target provided; cannot contain whitespace'
			);
		}
	}
}