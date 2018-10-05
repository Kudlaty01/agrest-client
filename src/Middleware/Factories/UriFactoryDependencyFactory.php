<?php

namespace Qdt01\AgRest\Middleware\Factories;

use Qdt01\AgRest\Middleware\{Filters\Uri\FragmentFilterInterface,
	Filters\Uri\PathFilterInterface,
	Filters\Uri\QueryFilterInterface,
	Filters\Uri\UserInfoFilterInterface,
	Validators\Uri\HostValidatorInterface,
	Validators\Uri\PathValidatorInterface,
	Validators\Uri\QueryValidatorInterface,
	Validators\Uri\SchemeValidator,
	Validators\Uri\UriPartsValidatorInterface,
	Validators\Uri\UserInfo\PasswordValidatorInterface,
	Validators\Uri\UserInfo\UserValidatorInterface};
use Qdt01\AgRest\Services\DependencyResolver;
use Qdt01\AgRest\Services\DependencyFactoryInterface;

/**
 * Class UriFactoryFactory
 *
 * @package \Qdt01\AgRest\Middleware\Factories
 */
class UriFactoryDependencyFactory implements DependencyFactoryInterface
{

	/**
	 * @param DependencyResolver $dependencyResolver
	 * @return UriFactory
	 * @throws \Qdt01\AgRest\Exceptions\UnresolvedDependencyException
	 */
	function createDependency(DependencyResolver $dependencyResolver)
	{
		$schemeValidator           = $dependencyResolver->get(SchemeValidator::class);
		$userIntoUserValidator     = $dependencyResolver->get(UserValidatorInterface::class);
		$userIntoPasswordValidator = $dependencyResolver->get(PasswordValidatorInterface::class);
		$userInfoFilter            = $dependencyResolver->get(UserInfoFilterInterface::class);
		$hostValidator             = $dependencyResolver->get(HostValidatorInterface::class);
		$pathValidator             = $dependencyResolver->get(PathValidatorInterface::class);
		$queryValidator            = $dependencyResolver->get(QueryValidatorInterface::class);
		$pathFilter                = $dependencyResolver->get(PathFilterInterface::class);
		$queryFilter               = $dependencyResolver->get(QueryFilterInterface::class);
		$fragmentFilter            = $dependencyResolver->get(FragmentFilterInterface::class);
		$uriPartsValidator         = $dependencyResolver->get(UriPartsValidatorInterface::class);
		return new UriFactory(
			$schemeValidator,
			$userIntoUserValidator,
			$userIntoPasswordValidator,
			$userInfoFilter,
			$hostValidator,
			$pathValidator,
			$queryValidator,
			$pathFilter,
			$queryFilter,
			$fragmentFilter,
			$uriPartsValidator
		);
	}
}