<?php

namespace Qdt01\AgRest\ApiCalls;

use Qdt01\AgRest\Models\ModelResultInterface;

interface ApiCallResultInterface
{
	function getModel(): ?ModelResultInterface;
}