<?php

namespace Qdt01\AgRest\Middleware\Validators\Response\StatusCode;

/**
 * Class StatusCodeValidator
 *
 * @package \Qdt01\AgRest\Middleware\Validators\Response
 */
class StatusCodeValidator implements StatusCodeValidatorInterface
{
	const STATUS_CODE_MIN_VALUE = 100;
	const STATUS_CODE_MAX_VALUE = 599;

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public function validate($value): void
	{
		if (!is_numeric($value)
			|| is_float($value)
			|| $value < self::STATUS_CODE_MIN_VALUE
			|| $value > self::STATUS_CODE_MAX_VALUE
		) {
			throw new \InvalidArgumentException(sprintf(
				'Invalid status code "%s"; must be an integer between %d and %d, inclusive',
				is_scalar($value) ? $value : gettype($value),
				self::STATUS_CODE_MIN_VALUE,
				self::STATUS_CODE_MAX_VALUE
			));
		}
	}
}