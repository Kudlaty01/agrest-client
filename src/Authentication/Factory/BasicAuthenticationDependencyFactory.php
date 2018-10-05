<?php

namespace Qdt01\AgRest\Authentication\Factory;

use Qdt01\AgRest\Authentication\BasicAuthorization;
use Qdt01\AgRest\Connector\ConnectorInterface;
use Qdt01\AgRest\Services\DependencyFactoryInterface;
use Qdt01\AgRest\Services\DependencyResolver;

/**
 * Class BasicAuthenticationFactory
 *
 * @package \Qdt01\AgRest\Authentication\Factory
 */
class BasicAuthenticationDependencyFactory implements DependencyFactoryInterface
{

	function createDependency(DependencyResolver $dependencyResolver)
	{
		/** @var ConnectorInterface $httpClient */
		$httpClient = $dependencyResolver->get(ConnectorInterface::class);
		return new BasicAuthorization($httpClient);
	}
}