<?php

namespace Qdt01\AgRest\Middleware\Filters\Message;


use Qdt01\AgRest\Middleware\Filters\FilterInterface;

/**
 * Class HeaderValuesFilter for header values filtering
 *
 * @package \Qdt01\AgRest\Validators
 */
interface HeaderValueFilterInterface extends FilterInterface
{
	/**
	 * @param mixed $value
	 * @return string[]
	 */
	public function filter($value): array;
}