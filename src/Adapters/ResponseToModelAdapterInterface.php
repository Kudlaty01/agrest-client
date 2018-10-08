<?php

namespace Qdt01\AgRest\Adapters;


use Qdt01\AgRest\Models\ModelResultInterface;

interface ResponseToModelAdapterInterface
{

	function getModel(): ModelResultInterface;
}