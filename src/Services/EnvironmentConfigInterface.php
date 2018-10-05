<?php

namespace Qdt01\AgRest\Services;

interface EnvironmentConfigInterface
{
	function getBaseUrl(): string;

	function getModuleRoutes(): ModuleRoutesInterface;

//	/**
//	 * This is not about real routing.
//	 * Rather returns a single url fragment
//	 * @param string $routeName
//	 * @return ModuleRoutesInterface
//	 */
//	function getModuleRoute(string $routeName): string;

}