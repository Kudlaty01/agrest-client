<?php

namespace Qdt01\AgRest\Environments\ISystems\ApiCalls;

use Qdt01\AgRest\ApiCalls\ApiCallResultInterface;
use Qdt01\AgRest\Models\ModelResultInterface;

/**
 * Class ProducerApiCallResult
 *
 * @package \Qdt01\AgRest\Environments\ISystems\ApiCalls
 */
class ProducerApiCallResult implements ApiCallResultInterface
{
	private $model;

	/**
	 * ProducerApiCallResult constructor.
	 * @param $model
	 */
	public function __construct($model)
	{
		$this->model = $model;
	}

	function getModel(): ?ModelResultInterface
	{
		return $this->model;

	}
}