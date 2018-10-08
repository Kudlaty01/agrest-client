<?php

namespace Qdt01\AgRest\Environments\ISystems\ApiCalls;

use Psr\Http\Message\ResponseInterface;
use Qdt01\AgRest\ApiCalls\AbstractQueryApiCall;
use Qdt01\AgRest\ApiCalls\ApiCallResultInterface;
use Qdt01\AgRest\Domains\ModelDomainInterface;
use Qdt01\AgRest\Environments\ISystems\Models\Adapters\ResponseToProducerAdapter;
use Qdt01\AgRest\Modules\ISystems\Domains\ProducerModelDomain;

/**
 * Class GetAllProducersApiCall
 *
 * @package \Qdt01\AgRest\Environments\ISystems\ApiCalls
 */
class GetAllProducersApiCall extends AbstractQueryApiCall
{

	function getDomain(): ModelDomainInterface
	{
		if (empty($this->modelDomain)) {
			$this->modelDomain = new ProducerModelDomain();
		}
		return $this->modelDomain;
	}

	public function setResponse(ResponseInterface $response): void
	{
		$this->responseToModelAdapter = new ResponseToProducerAdapter($response);
		$this->model                  = $this->responseToModelAdapter->getModel();
	}

	public function getApiCallResult(): ApiCallResultInterface
	{
		return new ProducerApiCallResult($this->model);
	}

}
