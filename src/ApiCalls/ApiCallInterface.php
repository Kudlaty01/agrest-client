<?php

namespace Qdt01\AgRest\ApiCalls;

use Psr\Http\Message\RequestFactoryInterface;
use Qdt01\AgRest\Authentication\AuthorizationInterface;
use Qdt01\AgRest\Connector\ConnectorInterface;
use Qdt01\AgRest\Domains\ModelDomainInterface;
use Qdt01\AgRest\Modules\ISystems\Models\ModelInterface;

interface ApiCallInterface
{
	public function getDomain(): ModelDomainInterface;

	public function getModel(): ModelInterface;

	/**
	 * @param ConnectorInterface $connector
	 * @return ApiCallInterface
	 */
	public function setConnector(ConnectorInterface $connector): ApiCallInterface;

	public function setAuthorization(AuthorizationInterface $authorization): ApiCallInterface;

	public function setBaseEndpoint(string $baseEndpoint): ApiCallInterface;

	public function setRequestFactory(RequestFactoryInterface $requestFactory): ApiCallInterface;

	/**
	 * perform the call
	 * @return mixed
	 */
	public function call(): ApiCallResultInterface;


}