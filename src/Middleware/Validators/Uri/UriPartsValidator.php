<?php

namespace Qdt01\AgRest\Middleware\Validators\Uri;

/**
 * Class UriPartsValidator
 *
 * @package \Qdt01\AgRest\Middleware\Validators\Uri
 */
class UriPartsValidator implements UriPartsValidatorInterface
{

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public function validate($value): void
	{

		if (false === $value) {
			throw new \InvalidArgumentException(
				'The source URI string appears to be malformed'
			);
		}
	}
}