<?php

namespace Qdt01\AgRest\Adapters;

use Qdt01\AgRest\Modules\ISystems\Models\ModelInterface;

/**
 * Class AbstractModelToRequestAdapter
 *
 * @package \Qdt01\AgRest\Adapters
 */
abstract class AbstractModelToRequestAdapter implements ModelToRequestAdapterInterface
{
	/**
	 * @var ModelInterface
	 */
	protected $model;

	/**
	 * AbstractModelToRequestAdapter constructor.
	 * @param ModelInterface $model
	 */
	public function __construct(ModelInterface $model)
	{
		$this->model = $model;
	}
}