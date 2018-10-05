<?php

namespace Qdt01\AgRest\Middleware;

/**
 * Class UrlEncoder
 *
 * @package \Qdt01\AgRest\Middleware\Filters\Uri
 */
class UrlEncoder
{

	function urlEncodeChar(array $matches): string
	{
		return rawurlencode($matches[0]);
	}
}