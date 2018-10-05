<?php

namespace Qdt01\AgRest\Middleware\Response;

/**
 * Class AbstractContentTypeResponse
 *
 * @package \Qdt01\AgRest\Middleware\Response
 */
abstract class ContentTypeResponse extends Response
{

	const CONTENT_TYPE = 'content-type';

	protected function setContentType(string $contentType, array $headers) : array
	{
		$hasContentType = array_reduce(array_keys($headers), function ($carry, $item) {
			return $carry ?? (strtolower($item) === 'content-type');
		}, false);

		if (! $hasContentType) {
			$headers[self::CONTENT_TYPE] = [$contentType];
		}

		return $headers;
	}

}