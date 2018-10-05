<?php

namespace Qdt01\AgRest\Services;

use Qdt01\AgRest\Middleware\Validators\HeaderValueFilterInterface;

/**
 * Interface DependencyRegistrarInterface
 * name may be confusing, but it defines a main class being able to register dependencies to DependencyRegistrar
 * @package Qdt01\AgRest\Services
 */
interface DependencyRegistrarInterface
{
	/**
	 * @param DependencyResolver $dependencyRegistrar
	 * @return DependencyResolver
	 */
	public function registerDependencies(DependencyResolver $dependencyRegistrar): DependencyResolver;

	/**
	 * Gets the order of the module in dependency resolution chain
	 * @return int
	 */
	public function getOrder(): int;
}