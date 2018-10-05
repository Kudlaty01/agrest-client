<?php

namespace Qdt01\AgRest\Services;

use Qdt01\AgRest\Authentication\AuthorizationInterface;
use Qdt01\AgRest\Client\RestClientInterface;
use Qdt01\AgRest\Core;

/**
 * Class AbstractModule
 *
 * @package \Qdt01\AgRest\Services
 */
abstract class AbstractEnvironment implements EnvironmentInterface
{
	/** @var DependencyResolver */
	protected $dependencyRegistrar;

	/** @var RestClientInterface */
	protected $client;
	/** @var AuthorizationInterface */
	protected $authorization;

	/**
	 * AbstractModule constructor.
	 * @throws \Qdt01\AgRest\Exceptions\UnresolvedDependencyException
	 */
	public function __construct()
	{
		$core                = new Core();
		$dependencyRegistrar = $core->init()->getDependencyRegistrar();
		/**
		 * TODO: Think about it twice it it's gonna be a field in module and might be exposed
		 */
		$this->dependencyRegistrar = $this->registerDependencies($dependencyRegistrar);
		$authentication            = $this->dependencyRegistrar->get(AuthorizationInterface::class);
		$this->authorization       = $this->configureAuthorization($authentication);

		$this->client = $this->dependencyRegistrar->get(RestClientInterface::class);
		$this->client->setAuthentication($this->authorization)
			->setEndpointBaseAddress($this->getEndpointBaseAddress());
	}

	/**
	 * @return RestClientInterface
	 */
	public function getClient(): RestClientInterface
	{
		return $this->client;
	}

	abstract public function configureAuthorization(AuthorizationInterface $authentication): AuthorizationInterface;

}