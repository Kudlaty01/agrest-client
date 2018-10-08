<?php

namespace Qdt01\AgRest\Middleware\Filters\Factories;

use Qdt01\AgRest\Middleware\Filters\Message\HeaderValueFilter;
use Qdt01\AgRest\Middleware\Validators\Message\HeaderValueValidatorInterface;
use Qdt01\AgRest\Services\DependencyFactoryInterface;
use Qdt01\AgRest\Services\DependencyResolver;

/**
 * Class HeaderValuesFilterFactory
 *
 * @package \Qdt01\AgRest\Middleware\Validators\Factories
 */
class HeaderValuesFilterDependencyFactory implements DependencyFactoryInterface
{

	/**
	 * @param DependencyResolver $dependencyResolver
	 * @return HeaderValueFilter
	 * @throws \Qdt01\AgRest\Exceptions\UnresolvedDependencyException
	 */
	function createDependency(DependencyResolver $dependencyResolver)
	{
		/** @var HeaderValueValidatorInterface $headerValueValidator */
		$headerValueValidator = $dependencyResolver->get(HeaderValueValidatorInterface::class);
		return new HeaderValueFilter($headerValueValidator);
	}
}