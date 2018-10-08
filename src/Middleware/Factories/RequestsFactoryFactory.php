<?php

namespace Qdt01\AgRest\Middleware\Factories;

use Psr\Http\Message\StreamFactoryInterface;
use Qdt01\AgRest\Middleware\Filters\Message\HeaderValueFilterInterface;
use Qdt01\AgRest\Middleware\Validators\Message\HeaderNameValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Message\HeaderValueValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Message\MessageStreamValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Message\ProtocolVersionValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Request\MethodValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Request\RequestTargetValidatorInterface;
use Qdt01\AgRest\Services\DependencyFactoryInterface;
use Qdt01\AgRest\Services\DependencyResolver;

/**
 * Class RequestsFactoryFactory - funny name, but keeps the convention
 *
 * @package \Qdt01\AgRest\Middleware\Factories
 */
class RequestsFactoryFactory implements DependencyFactoryInterface
{


	/**
	 * @param DependencyResolver $dependencyResolver
	 * @return RequestFactory
	 * @throws \Qdt01\AgRest\Exceptions\UnresolvedDependencyException
	 */
	function createDependency(DependencyResolver $dependencyResolver)
	{
		$headerNameValidator      = $dependencyResolver->get(HeaderNameValidatorInterface::class);
		$headerValueValidator     = $dependencyResolver->get(HeaderValueValidatorInterface::class);
		$protocolVersionValidator = $dependencyResolver->get(ProtocolVersionValidatorInterface::class);
		$headerValueFilter        = $dependencyResolver->get(HeaderValueFilterInterface::class);
		$streamValidator          = $dependencyResolver->get(MessageStreamValidatorInterface::class);
		$streamFactory            = $dependencyResolver->get(StreamFactoryInterface::class);
		$methodValidator          = $dependencyResolver->get(MethodValidatorInterface::class);
		$requestTargetValidator   = $dependencyResolver->get(RequestTargetValidatorInterface::class);
		return new RequestFactory($headerNameValidator, $headerValueValidator, $protocolVersionValidator, $headerValueFilter, $streamValidator, $streamFactory, $methodValidator, $requestTargetValidator);
	}
}