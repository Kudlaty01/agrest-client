<?php

namespace Qdt01\AgRest\Services;

use Qdt01\AgRest\Authentication\AuthorizationInterface;
use Qdt01\AgRest\Client\RestClientInterface;

interface EnvironmentInterface
{
	function registerDependencies(DependencyResolver $dependencyRegistrar): DependencyResolver;

	function getEndpointBaseAddress(): string;

	public function getClient(): RestClientInterface;

	public function configureAuthorization(AuthorizationInterface $authentication): AuthorizationInterface;


}