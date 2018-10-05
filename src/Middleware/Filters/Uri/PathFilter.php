<?php

namespace Qdt01\AgRest\Middleware\Filters\Uri;

use Qdt01\AgRest\Middleware\Uri;
use Qdt01\AgRest\Middleware\UrlEncoder;

/**
 * Class PathFilter
 *
 * @package \Qdt01\AgRest\Middleware\Filters\Uri
 */
class PathFilter implements PathFilterInterface
{

	/**
	 * @param string $value
	 * @return mixed
	 */
	function filter($value): string
	{
		$value = preg_replace_callback(
			'/(?:[^' . Uri::CHAR_UNRESERVED . ')(:@&=\+\$,\/;%]+|%(?![A-Fa-f0-9]{2}))/u',
			[new UrlEncoder, 'urlEncodeChar'],
			$value
		);

		if ('' === $value) {
			// No path
			return $value;
		}

		if ($value[0] !== '/') {
			// Relative path
			return $value;
		}

		// Ensure only one leading slash, to prevent XSS attempts.
		return '/' . ltrim($value, '/');
	}
}