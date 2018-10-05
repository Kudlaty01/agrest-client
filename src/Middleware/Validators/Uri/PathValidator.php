<?php

namespace Qdt01\AgRest\Middleware\Validators\Uri;

/**
 * Class PathValidator
 *
 * @package \Qdt01\AgRest\Middleware\Filters\Uri
 */
class PathValidator implements PathValidatorInterface
{

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public function validate($value): void
	{
		if (!is_string($value)) {
			throw new \InvalidArgumentException(
				'Invalid path provided; must be a string'
			);
		}

		if (strpos($value, '?') !== false) {
			throw new \InvalidArgumentException(
				'Invalid path provided; must not contain a query string'
			);
		}

		if (strpos($value, '#') !== false) {
			throw new \InvalidArgumentException(
				'Invalid path provided; must not contain a URI fragment'
			);
		}
	}
}