<?php

namespace Qdt01\AgRest\ApiCalls;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Qdt01\AgRest\Domains\ModelDomainInterface;
use Qdt01\AgRest\Modules\ISystems\Models\ModelInterface;

interface ApiCallInterface
{
	public function getDomain(): ModelDomainInterface;

	public function getModel(): ModelInterface;

	public function setBaseEndpoint(string $baseEndpoint): ApiCallInterface;

	public function setRequestFactory(RequestFactoryInterface $requestFactory): ApiCallInterface;

	public function getRequest(): RequestInterface;

	public function setResponse(ResponseInterface $response): void;

	public function getApiCallResult(): ApiCallResultInterface;

}