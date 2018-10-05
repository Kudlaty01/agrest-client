<?php

namespace Qdt01\AgRest;

use Qdt01\AgRest\Authentication\{AuthorizationInterface, Factory\BasicAuthenticationDependencyFactory};
use Qdt01\AgRest\Connector\{ConnectorInterface, CurlConnector};
use Qdt01\AgRest\Services\{DependencyRegistrarInterface, DependencyResolver};

/**
 * Class Application
 *
 * @package \Qdt01\AgRest
 */
class Core implements DependencyRegistrarInterface
{
	/** @var DependencyResolver */
	protected $dependencyRegistrar;

	public function init(): self
	{
		$middlewareCore            = new \Qdt01\AgRest\Middleware\Core();
		$middlewareDependencies    = $middlewareCore->registerDependencies(new DependencyResolver([]));
		$this->dependencyRegistrar = $this->registerDependencies($middlewareDependencies);
		return $this;
	}

	/**
	 * @return DependencyResolver
	 */
	public function getDependencyRegistrar(): DependencyResolver
	{
		return $this->dependencyRegistrar;
	}

	/**
	 * @param DependencyResolver $dependencyRegistrar
	 * @return DependencyResolver
	 */
	public function registerDependencies(DependencyResolver $dependencyRegistrar): DependencyResolver
	{
		$invokables   = [
			ConnectorInterface::class => CurlConnector::class,
		];
		$factories    = [
			AuthorizationInterface::class => BasicAuthenticationDependencyFactory::class,
		];
		$initializers = [

		];
		foreach ($invokables as $interface => $classConstructor) {
			$dependencyRegistrar->addInvokableDependency($interface, $classConstructor);
		}
		foreach ($factories as $interface => $factoryClass) {
			$dependencyRegistrar->addFactoryDependency($interface, $factoryClass);
		}
		foreach ($initializers as $key => $initializer) {
			$dependencyRegistrar->addInitializer($key, $initializer);
		}

		return $dependencyRegistrar;
	}

	/**
	 * Gets the order of the module in dependency resolution chain
	 * @return int
	 */
	public function getOrder(): int
	{
		return 99; //set it high to allow easy override
	}
}