<?php

namespace Qdt01\AgRest\Middleware\Factories;

use Psr\Http\Message\ResponseInterface;
use Qdt01\AgRest\Middleware\Response\JsonResponse;

/**
 * Class JsonResponseFactory
 *
 * @package \Qdt01\AgRest\Middleware\Factories
 */
class JsonResponseFactory extends AbstractResponseFactory
{

	/**
	 * Create a new response.
	 *
	 * @param int    $code HTTP status code; defaults to 200
	 * @param string $reasonPhrase Reason phrase to associate with status code
	 *     in generated response; if none is provided implementations MAY use
	 *     the defaults as suggested in the HTTP specification.
	 *
	 * @return ResponseInterface
	 */
	public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
	{
		$response = new JsonResponse($this->protocolVersionValidator,
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