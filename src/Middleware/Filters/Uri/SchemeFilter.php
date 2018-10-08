<?php

namespace Qdt01\AgRest\Middleware\Filters\Uri;


/**
 * Class SchemeFilter
 *
 * @package \Qdt01\AgRest\Middleware
 */
class SchemeFilter implements SchemeFilterInterface
{

	/**
	 * @var int[]
	 */
	private $allowedSchemes = [
		'http'  => 80,
		'https' => 443,
	];

	/**
	 * @param mixed $value
	 * @return mixed
	 */
	function filter($value)
	{
		$value = strtolower($value);
		$value = preg_replace('#:(//)?$#', '', $value);

		if ('' === $value) {
			return '';
		}

		if (!isset($this->allowedSchemes[$value])) {
			throw new \InvalidArgumentException(sprintf(
				'Unsupported scheme "%s"; must be any empty string or in the set (%s)',
				$value,
				implode(', ', array_keys($this->allowedSchemes))
			));
		}

		return $value;
	}
}