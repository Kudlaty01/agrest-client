<?php

namespace Qdt01\AgRest\Environments\ISystems\ApiCalls;

use Qdt01\AgRest\ApiCalls\AbstractQueryApiCall;
use Qdt01\AgRest\ApiCalls\ApiCallResultInterface;
use Qdt01\AgRest\Domains\ModelDomainInterface;
use Qdt01\AgRest\Modules\ISystems\Domains\ProducerModelDomain;
use Qdt01\AgRest\Modules\ISystems\Models\ModelInterface;

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

	function getModel(): ModelInterface
	{
		// TODO: Implement getModel() method.
	}

	/**
	 * perform the call
	 * @return mixed
	 */
	public function call(): ApiCallResultInterface
	{
		// TODO: Implement call() method.
	}
}