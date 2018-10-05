<?php

namespace Qdt01\AgRest\Middleware\Factories;

use Psr\Http\Message\{ResponseInterface};
use Qdt01\AgRest\Middleware\Response\Response;

/**
 * Class ResponseFactory
 *
 * @package \Qdt01\AgRest\Middleware\Factories
 */
class ResponseFactory extends AbstractResponseFactory
{

	public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
	{
		$response = new Response($this->protocolVersionValidator,
			$this->headerNameValidator,
			$this->headerValueValidator,
			$this->headerValueFilter,
			$this->streamValidator,
			$this->streamFactory,
			$this->statusCodeValidator,
			$this->reasonValidator);
		return $response->withStatus($code, $reasonPhrase);
	}
}