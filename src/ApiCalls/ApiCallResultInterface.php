<?php

namespace Qdt01\AgRest\ApiCalls;

use Qdt01\AgRest\Modules\ISystems\Models\ModelInterface;

interface ApiCallResultInterface
{
	function getModel(): ModelInterface;
}