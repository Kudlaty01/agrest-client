<?php

namespace Qdt01\AgRest\Middleware\Filters;

interface FilterInterface
{
	/**
	 * @param mixed $value
	 * @return mixed
	 */
	function filter($value);

}