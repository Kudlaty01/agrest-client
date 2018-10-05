<?php

namespace Qdt01\AgRest\Adapters;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Qdt01\AgRest\Middleware\Response\Response;
use Qdt01\AgRest\Middleware\Stream\Stream;

/**
 * Class CurlInfoResponseAdapter
 *
 * @package \Qdt01\AgRest\Adapters
 */
class CurlInfoResponseAdapter implements ResponseAdapterInterface
{
	/**
	 * @var array
	 */
	private $curlInfo;
	/**
	 * @var string
	 */
	private $responseBody;
	/**
	 * @var ResponseFactoryInterface
	 */
	private $responseFactory;

	/**
	 * CurlInfoResponseAdapter constructor.
	 * @param ResponseFactoryInterface $responseFactory
	 */
	const HTTP_CODE = 'http_code';

	const HEADER_SIZE = 'header_size';

	public function __construct(ResponseFactoryInterface $responseFactory)
	{
		$this->responseFactory = $responseFactory;
	}


	public function setCurlInfo(array $curlInfo, string $responseBody): self
	{
		$this->curlInfo     = $curlInfo;
		$this->responseBody = $responseBody;
	}

	public function getResponse(): ResponseInterface
	{
		if (!isset($this->curlInfo)) {
			throw new \RuntimeException("Curl info has to be set before conversion!");
		}
		$response      = $this->responseFactory->createResponse($this->curlInfo[self::HTTP_CODE]);
		$headerLength  = $this->curlInfo[self::HEADER_SIZE];
		$headersString = substr($this->responseBody, 0, $headerLength);
		$headersRaw    = array_filter(preg_split('/\r?\n/', $headersString));
		$headers       = array_map(function ($header) {
			return explode(': ', $header);
		}, $headersRaw);
		$bodyText      = substr($this->responseBody, $headerLength);
		$stream        = fopen('php://memory', Stream::MODE_READ_WRITE);
		fwrite($stream, $bodyText);
		/**
		 * TODO: I know it's dirty, have to do something about it
		 */
		if ($response instanceof Response) {
			$headersIndexed = array_column($headers, 1, 0);
			$response->initialize($stream, $this->curlInfo[self::HTTP_CODE], $headersIndexed);
		} else {
			throw new \RuntimeException("Try implementing something easier to initialize!");
		}
		return $response;
	}
}