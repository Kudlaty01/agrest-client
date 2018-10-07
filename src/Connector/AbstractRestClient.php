<?php

namespace Qdt01\AgRest\Connector;

use Psr\Http\Message\RequestFactoryInterface;
use Qdt01\AgRest\ApiCalls\{ApiCallInterface, ApiCallResultInterface, CommandApiCallInterface, QueryApiCallInterface};
use Qdt01\AgRest\Authentication\AuthorizationInterface;
use Qdt01\AgRest\Client\RestClientInterface;
use Qdt01\AgRest\Domains\ModelDomainInterface;

/**
 * Class AbstractRestClient
 *
 * @package \Qdt01\AgRest\Client
 */
abstract class AbstractRestClient implements RestClientInterface
{
	/** @var string */
	protected $baseEndpoint;

	/** @var ConnectorInterface */
	protected $connector;
	/**
	 * @var AuthorizationInterface
	 */
	protected $authorization;
	/**
	 * @var ModelDomainInterface
	 */
	protected $domain;
	/**
	 * @var RequestFactoryInterface
	 */
	private $requestFactory;

	/**
	 * AbstractRestClient constructor.
	 * @param string                  $baseEndpoint
	 * @param ConnectorInterface      $connector
	 * @param AuthorizationInterface  $authentication
	 * @param RequestFactoryInterface $requestFactory
	 */
	public function __construct(string $baseEndpoint, ConnectorInterface $connector, AuthorizationInterface $authentication, RequestFactoryInterface $requestFactory)
	{
		$this->baseEndpoint   = $baseEndpoint;
		$this->connector      = $connector;
		$this->authorization  = $authentication;
		$this->requestFactory = $requestFactory;
	}

	public function exec(CommandApiCallInterface $commandApiCall): ApiCallResultInterface
	{
		$this->setDependencies($commandApiCall);
	}

	public function get(QueryApiCallInterface $queryApiCall): ApiCallResultInterface
	{
		$result = $this->setDependencies($queryApiCall)->call();
		return $result;

	}

	/**
	 * @param CommandApiCallInterface $commandApiCall
	 */
	protected function setDependencies(ApiCallInterface $apiCall): ApiCallInterface
	{
		$apiCall
			->setBaseEndpoint($this->baseEndpoint)
			->setRequestFactory($this->requestFactory);
		return $apiCall;
	}


}