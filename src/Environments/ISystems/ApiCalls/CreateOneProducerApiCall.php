<?php

namespace Qdt01\AgRest\Environments\ISystems\ApiCalls;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Qdt01\AgRest\ApiCalls\AbstractApiCall;
use Qdt01\AgRest\ApiCalls\ApiCallResultInterface;
use Qdt01\AgRest\ApiCalls\CommandApiCallInterface;
use Qdt01\AgRest\Domains\ModelDomainInterface;
use Qdt01\AgRest\Modules\ISystems\Domains\ProducerModelDomain;
use Qdt01\AgRest\Modules\ISystems\Models\ModelInterface;
use Qdt01\AgRest\Modules\ISystems\Models\Producer;

/**
 * Class CreateOneProducerApiCall
 *
 * @package \Qdt01\AgRest\Environments\ISystems\ApiCalls
 */
class CreateOneProducerApiCall extends AbstractApiCall implements CommandApiCallInterface
{
	protected $modelDomain;


	/**
	 * CreateOneProducerApiCall constructor.
	 */
	public function __construct(Producer $producer)
	{
		$this->model = $producer;
	}

	function getDomain(): ModelDomainInterface
	{
		$this->modelDomain = new ProducerModelDomain();
		return $this->modelDomain;
	}

	/**
	 * @return Producer
	 */
	function getModel(): ModelInterface
	{
		return $this->model;
	}

	public function getRequest(): RequestInterface
	{
		// TODO: Implement getRequest() method.
	}

	public function setResponse(ResponseInterface $response): void
	{
		// TODO: Implement setResponse() method.
	}

	public function getApiCallResult(): ApiCallResultInterface
	{
		// TODO: Implement getApiCallResult() method.
	}
}
