<?php

namespace Qdt01\AgRest\Middleware\Validators\Uri;

/**
 * Class QueryValidator
 *
 * @package \Qdt01\AgRest\Middleware\Filters\Uri
 */
class QueryValidator implements QueryValidatorInterface
{

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public function validate($value): void
	{
		if (!is_string($value)) {
			throw new \InvalidArgumentException(
				'Query string must be a string'
			);
		}

		if (strpos($value, '#') !== false) {
			throw new \InvalidArgumentException(
				'Query string must not include a URI fragment'
			);
		}
	}
}