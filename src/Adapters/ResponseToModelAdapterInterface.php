<?php

namespace Qdt01\AgRest\Adapters;

use Qdt01\AgRest\Modules\ISystems\Models\ModelInterface;

interface ResponseToModelAdapterInterface
{

	function getModel(): ModelInterface;
}