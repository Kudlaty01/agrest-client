<?php

namespace Qdt01\AgRest\Middleware;

use Qdt01\AgRest\Middleware\Factories\RequestsFactoryFactory;
use Qdt01\AgRest\Middleware\Factories\RequestsFactoryInterfaceBak;
use Qdt01\AgRest\Middleware\Filters\Factories\HeaderValuesFilterDependencyFactory;
use Qdt01\AgRest\Middleware\Filters\Message\HeaderValueFilterInterface;
use Qdt01\AgRest\Middleware\Filters\Uri\FragmentFilter;
use Qdt01\AgRest\Middleware\Filters\Uri\FragmentFilterInterface;
use Qdt01\AgRest\Middleware\Filters\Uri\PathFilter;
use Qdt01\AgRest\Middleware\Filters\Uri\PathFilterInterface;
use Qdt01\AgRest\Middleware\Filters\Uri\QueryFilter;
use Qdt01\AgRest\Middleware\Filters\Uri\QueryFilterInterface;
use Qdt01\AgRest\Middleware\Filters\Uri\QueryOrFragmentFilter;
use Qdt01\AgRest\Middleware\Filters\Uri\QueryOrFragmentFilterInterface;
use Qdt01\AgRest\Middleware\Filters\Uri\SchemeFilter;
use Qdt01\AgRest\Middleware\Filters\Uri\SchemeFilterInterface;
use Qdt01\AgRest\Middleware\Filters\Uri\UserInfoFilter;
use Qdt01\AgRest\Middleware\Filters\Uri\UserInfoFilterInterface;
use Qdt01\AgRest\Middleware\Validators\Message\HeaderNameValidator;
use Qdt01\AgRest\Middleware\Validators\Message\HeaderNameValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Message\HeaderValueValidator;
use Qdt01\AgRest\Middleware\Validators\Message\HeaderValueValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Message\MessageStreamValidator;
use Qdt01\AgRest\Middleware\Validators\Message\MessageStreamValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Message\ProtocolVersionValidator;
use Qdt01\AgRest\Middleware\Validators\Message\ProtocolVersionValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Request\MethodValidator;
use Qdt01\AgRest\Middleware\Validators\Request\MethodValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Request\RequestTargetValidator;
use Qdt01\AgRest\Middleware\Validators\Request\RequestTargetValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Response\StatusCode\ReasonPhraseValidator;
use Qdt01\AgRest\Middleware\Validators\Response\StatusCode\ReasonPhraseValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Response\StatusCode\StatusCodeValidator;
use Qdt01\AgRest\Middleware\Validators\Response\StatusCode\StatusCodeValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Stream\ResourceValidator;
use Qdt01\AgRest\Middleware\Validators\Stream\ResourceValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Stream\StreamValidator;
use Qdt01\AgRest\Middleware\Validators\Stream\StreamValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Uri\FragmentValidator;
use Qdt01\AgRest\Middleware\Validators\Uri\FragmentValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Uri\HostValidator;
use Qdt01\AgRest\Middleware\Validators\Uri\HostValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Uri\PathValidator;
use Qdt01\AgRest\Middleware\Validators\Uri\PathValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Uri\PortValidator;
use Qdt01\AgRest\Middleware\Validators\Uri\PortValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Uri\QueryValidator;
use Qdt01\AgRest\Middleware\Validators\Uri\QueryValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Uri\SchemeValidator;
use Qdt01\AgRest\Middleware\Validators\Uri\SchemeValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Uri\UriPartsValidator;
use Qdt01\AgRest\Middleware\Validators\Uri\UriPartsValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Uri\UserInfo\PasswordValidator;
use Qdt01\AgRest\Middleware\Validators\Uri\UserInfo\PasswordValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Uri\UserInfo\UserValidator;
use Qdt01\AgRest\Middleware\Validators\Uri\UserInfo\UserValidatorInterface;
use Qdt01\AgRest\Services\DependencyRegistrarInterface;
use Qdt01\AgRest\Services\DependencyResolver;

/**
 * Class Core
 *
 * @package \Qdt01\AgRest\Middleware
 */
class Core implements DependencyRegistrarInterface
{

	/**
	 * @param DependencyResolver $dependencyRegistrar
	 * @return DependencyResolver
	 */
	public function registerDependencies(DependencyResolver $dependencyRegistrar): DependencyResolver
	{
		$invokables   = [
			//  Validiators
			MessageStreamValidatorInterface::class   => MessageStreamValidator::class,
			HeaderNameValidatorInterface::class      => HeaderNameValidator::class,
			ProtocolVersionValidatorInterface::class => ProtocolVersionValidator::class,
			HeaderValueValidatorInterface::class     => HeaderValueValidator::class,
			StatusCodeValidatorInterface::class      => StatusCodeValidator::class,
			ReasonPhraseValidatorInterface::class    => ReasonPhraseValidator::class,
			RequestTargetValidatorInterface::class   => RequestTargetValidator::class,
			MethodValidatorInterface::class          => MethodValidator::class,
			UriPartsValidatorInterface::class        => UriPartsValidator::class,
			PortValidatorInterface::class            => PortValidator::class,
			SchemeValidatorInterface::class          => SchemeValidator::class,
			FragmentValidatorInterface::class        => FragmentValidator::class,
			QueryValidatorInterface::class           => QueryValidator::class,
			HostValidatorInterface::class            => HostValidator::class,
			PasswordValidatorInterface::class        => PasswordValidator::class,
			UserValidatorInterface::class            => UserValidator::class,
			PathValidatorInterface::class            => PathValidator::class,
			ResourceValidatorInterface::class        => ResourceValidator::class,
			StreamValidatorInterface::class          => StreamValidator::class,

			//  Filters
			PathFilterInterface::class               => PathFilter::class,
			FragmentFilterInterface::class           => FragmentFilter::class,
			QueryOrFragmentFilterInterface::class    => QueryOrFragmentFilter::class,
			SchemeFilterInterface::class             => SchemeFilter::class,
			UserInfoFilterInterface::class           => UserInfoFilter::class,
			QueryFilterInterface::class              => QueryFilter::class,
		];
		$factories    = [
			HeaderValueFilterInterface::class  => HeaderValuesFilterDependencyFactory::class,
			RequestsFactoryInterfaceBak::class => RequestsFactoryFactory::class,
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
		return 1;
	}
}