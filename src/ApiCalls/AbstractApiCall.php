<?php

namespace Qdt01\AgRest\ApiCalls;

use Psr\Http\Message\RequestFactoryInterface;
use Qdt01\AgRest\Authentication\AuthorizationInterface;
use Qdt01\AgRest\Connector\ConnectorInterface;
use Qdt01\AgRest\Domains\ModelDomainInterface;

/**
 * Class AbstractApiCall
 *
 * @package \Qdt01\AgRest\ApiCalls
 */
abstract class AbstractApiCall implements ApiCallInterface
{
	/**
	 * @var ConnectorInterface
	 */
	protected $connector;
	/**
	 * @var ModelDomainInterface
	 */
	protected $modelDomain;
	/**
	 * @var RequestFactoryInterface
	 */
	protected $requestFactory;
	/**
	 * @var AuthorizationInterface
	 */
	protected $authorization;
	/**
	 * @var string
	 */
	protected $baseEndpoint;

	/**
	 * @param ConnectorInterface $connector
	 */
	public function setConnector(ConnectorInterface $connector): ApiCallInterface
	{
		$this->connector = $connector;
		return $this;
	}

	/**
	 * @param AuthorizationInterface $authorization
	 * @return ApiCallInterface
	 */
	public function setAuthorization(AuthorizationInterface $authorization): ApiCallInterface
	{
		$this->authorization = $authorization;
		return $this;
	}

	/**
	 * @param string $baseEndpoint
	 * @return ApiCallInterface
	 */
	public function setBaseEndpoint(string $baseEndpoint): ApiCallInterface
	{
		$this->baseEndpoint = $baseEndpoint;
		return $this;
	}

	/**
	 * @param RequestFactoryInterface $requestFactory
	 * @return ApiCallInterface
	 */
	public function setRequestFactory(RequestFactoryInterface $requestFactory): ApiCallInterface
	{
		$this->requestFactory = $requestFactory;
		return $this;
	}

}