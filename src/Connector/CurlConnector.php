<?php

namespace Qdt01\AgRest\Connector;

use Psr\Http\Message\{RequestInterface, ResponseInterface};
use Qdt01\AgRest\Adapters\CurlInfoResponseAdapter;
use Qdt01\AgRest\Adapters\ResponseAdapterInterface;
use Qdt01\AgRest\Middleware\Request\RequestMethodInterface;

/**
 * Class CurlConnector
 *
 * @package \Qdt01\AgRest\Connector
 */
class CurlConnector extends AbstractConnector
{
	/**
	 * @var resource
	 */
	protected $curl;
	/**
	 * @var CurlInfoResponseAdapter
	 */
	private $responseAdapter;

	/**
	 * CurlConnector constructor.
	 * @param ResponseAdapterInterface $responseAdapter
	 */
	public function __construct(ResponseAdapterInterface $responseAdapter)
	{
		$this->curl            = curl_init();
		$this->responseAdapter = $responseAdapter;
	}


	function send(RequestInterface $request): ResponseInterface
	{
		$this->setHeaders($request->getHeaders());
		$data = $request->getBody()->getContents();

		curl_setopt_array($this->curl,
			[
				CURLOPT_VERBOSE        => 1,
				CURLOPT_HEADER         => 1,
				CURLOPT_URL            => $request->getUri(),
				CURLOPT_RETURNTRANSFER => 1,
			]);

		switch ($request->getMethod()) {
			case RequestMethodInterface::METHOD_GET:
				curl_setopt($this->curl, CURLOPT_HTTPGET, 1);
				break;
			case RequestMethodInterface::METHOD_POST:

				if ($data) {
					curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
				}
				break;
			default:
				curl_setopt($this->curl, CURLOPT_PUT, 1);
				break;
		}


		$result = curl_exec($this->curl);

		$curlInfo = curl_getinfo($this->curl);
		$this->responseAdapter->setCurlInfo($curlInfo, $result);

		return $this->responseAdapter->getResponse();
	}

	/**
	 * @param string[] $headers
	 * @return CurlConnector
	 */
	protected function setHeaders(array $headers): CurlConnector
	{
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array_map(function ($headerName, $headerValue) {
			return "$headerName: $headerValue";
		}, array_keys($headers), $headers));
		return $this;
	}

	/**
	 *
	 */
	public function __destruct()
	{
		curl_close($this->curl);
	}


}