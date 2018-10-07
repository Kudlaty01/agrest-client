<?php

namespace Qdt01\AgRest\Environments\ISystems\Models\Adapters;

use Psr\Http\Message\RequestInterface;
use Qdt01\AgRest\Adapters\AbstractModelToRequestAdapter;
use Qdt01\AgRest\Modules\ISystems\Models\Producer;

/**
 * Class ProducerToRequestAdapter
 *
 * @package \Qdt01\AgRest\Environments\ISystems\Adapters
 */
class ProducerToRequestAdapter extends AbstractModelToRequestAdapter
{
	/**
	 * @var Producer
	 */
	protected $model;


	function getRequest(RequestInterface $request): RequestInterface
	{
		$data = [
			$this->model->getName(),
			$this->model->getLogoFilename(),
			$this->model->getOrdering(),
			$this->model->getSiteUrl(),
			$this->model->getSourceId(),
		];
		$id   = $this->model->getId();
		if (!empty($id)) {
			$data['id'] = $id;
		}
		$jsonData = json_encode($data);
		/**
		 * TODO: implement body assignment
		 */
		$request = $request
			->withAddedHeader('Content-type', 'text/json');

		$request;
	}
}