<?php

namespace Qdt01\AgRest\Middleware\Validators\Response\StatusCode;

/**
 * Class ReasonPhraseValidator
 *
 * @package \Qdt01\AgRest\Middleware\Validators\Response\StatusCode
 */
class ReasonPhraseValidator implements ReasonPhraseValidatorInterface
{

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public function validate($value): void
	{
		if (!is_string($value)) {
			throw new \InvalidArgumentException(sprintf(
				'Unsupported response reason phrase; must be a string, received %s',
				is_object($value) ? get_class($value) : gettype($value)
			));
		}
	}
}