<?php

namespace Qdt01\AgRest\Services;

use Closure;
use Qdt01\AgRest\Exceptions\UnresolvedDependencyException;

/**
 * Class DependencyRegistrar
 *
 * @package \Qdt01\AgRest
 */
class DependencyResolver
{

	/**
	 * @var array
	 */
	private $config;
	private $invokables = [];
	private $factories = [];
	private $initializers = [];


	/**
	 * DependencyRegistrar constructor.
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
	}

	/**
	 * @param string $dependency
	 * @return mixed
	 * @throws UnresolvedDependencyException
	 */
	public function get(string $dependency)
	{
		$result = null;
		if (isset($this->invokables[$dependency])) {
			$class  = $this->invokables[$dependency];
			$result = new $class;
		} else if (isset($this->factories)) {
			$factory = $this->factories[$dependency];
			if (is_callable($factory)) {
				$result = $factory($this);
			} else {
				$factoryInstance = new $factory;
				if ($factoryInstance instanceof DependencyFactoryInterface) {
					$result = $factoryInstance->createDependency($this);
				}
			}
		}
		if ($result === null) {
			throw new UnresolvedDependencyException($dependency);
		}
		foreach ($this->initializers as $initializer) {
			if (is_callable($initializer)) {
				$result = $initializer($result);
			} else {
				$initializerInstance = new $initializer;
				if ($initializerInstance instanceof InitializerInterface) {
					$result = $initializerInstance->initialize($result);
				}
			}
		}

		return $result;
	}

	/**
	 * add dependency based on a parameterless constructor
	 * @param string $interface
	 * @param string $classConstructor
	 * @throws \InvalidArgumentException
	 */
	public function addInvokableDependency(string $interface, string $classConstructor): void
	{
		if (!class_exists($classConstructor)) {
			throw new \InvalidArgumentException(sprintf("Invokable %s dependency resolution of %s should be an instantiable class name!", $interface, $classConstructor));
		}
		$this->invokables[$interface] = $classConstructor;
	}

	/**
	 * Add dependency based on a factory injecting parameters
	 * @param string          $interface
	 * @param string| Closure $factoryClass
	 * @throws \InvalidArgumentException
	 */
	public function addFactoryDependency(string $interface, $factoryClass): void
	{
		if (!(is_callable($factoryClass)
			|| (class_exists($factoryClass) && is_subclass_of($factoryClass, DependencyFactoryInterface::class)))) {
			throw new \InvalidArgumentException(sprintf("Factory %s resolving dependency %s should be either a closure or a class implementing FactoryInterface", $factoryClass, $interface));

		}
		$this->factories[$interface] = $factoryClass;
	}

	/**
	 * Add initializer to be executed on every dependency resolved object
	 * @param string          $key
	 * @param string| Closure $initializer
	 * @throws \InvalidArgumentException
	 */
	public function addInitializer(string $key, $initializer)
	{
		if (!(is_callable($initializer)
			|| (class_exists($initializer) && is_subclass_of($initializer, InitializerInterface::class)))) {
			throw new \InvalidArgumentException(sprintf("Initializer %s resolving dependency %s should be either a closure or a class implementing FactoryInterface", $initializer, $key));

		}
		$this->initializers[$key] = $initializer;
	}


}