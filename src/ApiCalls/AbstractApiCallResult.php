<?php

namespace Qdt01\AgRest\ApiCalls;

use Qdt01\AgRest\Modules\ISystems\Models\ModelInterface;

/**
 * Class AbstractApiCallResponse
 *
 * @package \Qdt01\AgRest\ApiCalls
 */
abstract class AbstractApiCallResult implements ApiCallResultInterface
{
	/**
	 * @var ModelInterface
	 */
	protected $model;


	/**
	 * AbstractApiCallResponse constructor.
	 * @param ModelInterface $model
	 */
	public function __construct(ModelInterface $model)
	{
		$this->model = $model;
	}
}