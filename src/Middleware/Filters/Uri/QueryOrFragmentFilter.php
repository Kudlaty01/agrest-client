<?php

namespace Qdt01\AgRest\Middleware\Filters\Uri;

use Qdt01\AgRest\Middleware\{Uri, UrlEncoder};

/**
 * Class QueryOrFragmentFilter
 *
 * @package \Qdt01\AgRest\Middleware\Filters\Uri
 */
class QueryOrFragmentFilter implements QueryOrFragmentFilterInterface
{

	/**
	 * @param mixed $value
	 * @return mixed
	 */
	function filter($value)
	{
		return preg_replace_callback(
			'/(?:[^' . Uri::CHAR_UNRESERVED . Uri::CHAR_SUB_DELIMS . '%:@\/\?]+|%(?![A-Fa-f0-9]{2}))/u',
			[new UrlEncoder, 'urlEncodeChar'],
			$value
		);
	}
}