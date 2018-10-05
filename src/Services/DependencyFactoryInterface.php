<?php

namespace Qdt01\AgRest\Services;

interface DependencyFactoryInterface
{
	function createDependency(DependencyResolver $dependencyResolver);
}