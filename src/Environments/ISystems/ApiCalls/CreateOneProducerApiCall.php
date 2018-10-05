<?php

namespace Qdt01\AgRest\Environments\ISystems\ApiCalls;

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

	/**
	 * perform the call
	 * @return mixed
	 */
	public function call(): ApiCallResultInterface
	{
		// TODO: Implement call() method.
	}
}
