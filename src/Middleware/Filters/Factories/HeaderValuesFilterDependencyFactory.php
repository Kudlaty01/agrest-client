<?php

namespace Qdt01\AgRest\Middleware\Filters\Factories;

use Qdt01\AgRest\Middleware\Filters\Message\HeaderValueFilter;
use Qdt01\AgRest\Services\DependencyResolver;
use Qdt01\AgRest\Services\DependencyFactoryInterface;
use Qdt01\AgRest\Middleware\Validators\Message\HeaderValueValidatorInterface;

/**
 * Class HeaderValuesFilterFactory
 *
 * @package \Qdt01\AgRest\Middleware\Validators\Factories
 */
class HeaderValuesFilterDependencyFactory implements DependencyFactoryInterface
{

	function createDependency(DependencyResolver $dependencyResolver)
	{
		/** @var HeaderValueValidatorInterface $headerValueValidator */
		$headerValueValidator = $dependencyResolver->get(HeaderValueValidatorInterface::class);
		return new HeaderValueFilter($headerValueValidator);
	}
}