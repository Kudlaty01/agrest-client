<?php

namespace Qdt01\AgRest\Modules\ISystems;

use Psr\Http\Message\ResponseFactoryInterface;
use Qdt01\AgRest\Authentication\AuthorizationInterface;
use Qdt01\AgRest\Authentication\BasicAuthorization;
use Qdt01\AgRest\Middleware\Factories\JsonResponseFactory;
use Qdt01\AgRest\Services\AbstractEnvironment;
use Qdt01\AgRest\Services\DependencyResolver;

/**
 * Class ISystemsModule
 *
 * @package \Qdt01\AgRest\Modules\ISystems
 */
class ISystemsEnvironment extends AbstractEnvironment
{
	/**
	 * @var null|string
	 */
	private $user;
	/**
	 * @var null|string
	 */
	private $password;


	/**
	 * ISystemsEnvironment constructor.
	 * @param null|string $user
	 * @param null|string $password
	 * @throws \Qdt01\AgRest\Exceptions\UnresolvedDependencyException
	 */
	public function __construct(?string $user = null, ? string $password = null)
	{
		parent::__construct();
		$this->user     = $user;
		$this->password = $password;
	}

	function registerDependencies(DependencyResolver $dependencyRegistrar): DependencyResolver
	{
		$dependencyRegistrar->addFactoryDependency(ResponseFactoryInterface::class, JsonResponseFactory::class);
		return $dependencyRegistrar;
	}

	function getEndpointBaseAddress(): string
	{
		return "http://recruitment.ciatm.cloud.mns.pl/rest_api/shop_api/v1/";
	}

	/**
	 * @param AuthorizationInterface $authentication
	 * @return AuthorizationInterface
	 */
	public function configureAuthorization(AuthorizationInterface $authentication): AuthorizationInterface
	{
		if (empty($this->user) || empty($this->password)) {
			$filePath = __DIR__ . 'credentials.json';
			if (!file_exists($filePath)) {
				throw new \RuntimeException("The environment itself needs credentials to connect to the endpoint!");
			}
			$contents = file_get_contents($filePath);
			['user' => $user, 'pass' => $pass] = json_decode($contents, true);
		} else {
			$user = $this->user;
			$pass = $this->password;
		}
		/** @var BasicAuthorization $authentication */
		$authentication->setCredentials($user, $pass);
		return $authentication;
	}


}