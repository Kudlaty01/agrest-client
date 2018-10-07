<?php

namespace Qdt01\AgRest\ApiCalls;

use Psr\Http\Message\RequestFactoryInterface;
use Qdt01\AgRest\Adapters\ResponseToModelAdapterInterface;
use Qdt01\AgRest\Domains\ModelDomainInterface;
use Qdt01\AgRest\Modules\ISystems\Models\ModelInterface;

/**
 * Class AbstractApiCall
 *
 * @package \Qdt01\AgRest\ApiCalls
 */
abstract class AbstractApiCall implements ApiCallInterface
{
	/**
	 * @var ModelDomainInterface
	 */
	protected $modelDomain;
	/**
	 * @var RequestFactoryInterface
	 */
	protected $requestFactory;
	/**
	 * @var string
	 */
	protected $baseEndpoint;
	/**
	 * @var ModelInterface
	 */
	protected $model;
	/**
	 * @var ResponseToModelAdapterInterface
	 */
	protected $responseToModelAdapter;

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

	/**
	 * @return ModelInterface
	 */
	public function getModel(): ModelInterface
	{
		return $this->model;
	}


}