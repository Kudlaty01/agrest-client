<?php

namespace Qdt01\AgRest\Middleware\Filters\Uri;

use Qdt01\AgRest\Middleware\Uri;
use Qdt01\AgRest\Middleware\UrlEncoder;

/**
 * Class UserInfoFilter
 *
 * @package \Qdt01\AgRest\Middleware\Filters\Uri
 */
class UserInfoFilter implements UserInfoFilterInterface
{
	/**
	 * @param mixed $value
	 * @return mixed
	 */
	function filter($value)
	{
		return preg_replace_callback(
			'/(?:[^%' . Uri::CHAR_UNRESERVED . Uri::CHAR_SUB_DELIMS . ']+|%(?![A-Fa-f0-9]{2}))/u',
			[new UrlEncoder, 'urlEncodeChar'],
			$value
		);
	}
}