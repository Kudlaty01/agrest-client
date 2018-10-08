<?php

namespace Qdt01\AgRest\Environments\ISystems\Models\Adapters;

use Qdt01\AgRest\Adapters\AbstractResponseToModelAdapter;
use Qdt01\AgRest\Models\ModelResultInterface;
use Qdt01\AgRest\Modules\ISystems\Models\Producer;

/**
 * Class ResponseToProducerAdapter
 *
 * @package \Qdt01\AgRest\Environments\ISystems\Adapters
 */
class ResponseToProducerAdapter extends AbstractResponseToModelAdapter
{

	function getModel(): ModelResultInterface
	{
		$rawData  = $this->response->getBody()->getContents();
		$jsonData = json_decode($rawData);
		$model    = new Producer();
		$model->setName($jsonData->name)
			->setLogoFilename($jsonData->logo_filename)
			->setOrdering($jsonData->ordering)
			->setSiteUrl($jsonData->site_url)
			->setSourceId($jsonData->source_id);
		if (isset($jsonData->id)) {
			$model->setId($jsonData->id);
		}
		return $model;
	}
}