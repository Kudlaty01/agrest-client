<?php

namespace Qdt01\AgRest\Middleware\Filters\Uri;

/**
 * Class FragmentFilter
 *
 * @package \Qdt01\AgRest\Middleware\Filters\Uri
 */
class FragmentFilter implements FragmentFilterInterface
{
	/** @var QueryOrFragmentFilterInterface */
	protected $queryOrFragmentFilter;

	/**
	 * FragmentFilter constructor.
	 */
	public function __construct()
	{
		$this->queryOrFragmentFilter = new QueryOrFragmentFilter();
	}

	/**
	 * @param mixed $value
	 * @return mixed
	 */
	public function filter($value)
	{
		if ('' !== $value && strpos($value, '#') === 0) {
			$value = '%23' . substr($value, 1);
		}

		return $this->queryOrFragmentFilter->filter($value);
	}
}