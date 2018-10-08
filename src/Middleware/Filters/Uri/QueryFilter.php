<?php

namespace Qdt01\AgRest\Middleware\Filters\Uri;

/**
 * Class QueryFilter
 *
 * @package \Qdt01\AgRest\Middleware\Filters\Uri
 */
class QueryFilter implements QueryFilterInterface
{
	/** @var QueryOrFragmentFilterInterface */
	protected $queryOrFragmentFilter;

	/**
	 * QueryFilter constructor.
	 */
	public function __construct()
	{
		$this->queryOrFragmentFilter = new QueryOrFragmentFilter();
	}


	/**
	 * @param mixed $value
	 * @return mixed
	 */
	function filter($value)
	{
		if ('' !== $value && strpos($value, '?') === 0) {
			$value = substr($value, 1);
		}

		$parts = explode('&', $value);
		foreach ($parts as $index => $part) {
			[$key, $value] = $this->splitQueryValue($part);
			if ($value === null) {
				$parts[$index] = $this->queryOrFragmentFilter->filter($key);
				continue;
			}
			$parts[$index] = sprintf(
				'%s=%s',
				$this->queryOrFragmentFilter->filter($key),
				$this->queryOrFragmentFilter->filter($value)
			);
		}

		return implode('&', $parts);
	}

	/**
	 * @param string $value
	 * @return array
	 */
	private function splitQueryValue(string $value): array
	{
		$data = explode('=', $value, 2);
		if (!isset($data[1])) {
			$data[] = null;
		}
		return $data;
	}


}