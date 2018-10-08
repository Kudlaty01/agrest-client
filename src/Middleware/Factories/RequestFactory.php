<?php

namespace Qdt01\AgRest\Middleware\Factories;

use Psr\Http\Message\{RequestFactoryInterface, RequestInterface, StreamFactoryInterface};
use Qdt01\AgRest\Middleware\{Filters\Message\HeaderValueFilterInterface,
	Request\Request,
	Validators\Message\HeaderNameValidatorInterface,
	Validators\Message\HeaderValueValidatorInterface,
	Validators\Message\MessageStreamValidatorInterface,
	Validators\Message\ProtocolVersionValidatorInterface,
	Validators\Request\MethodValidatorInterface,
	Validators\Request\RequestTargetValidatorInterface};

/**
 * Class RequestFactory
 *
 * @package \Qdt01\AgRest\Middleware\Factories
 */
class RequestFactory implements RequestFactoryInterface
{
	/**
	 * @var HeaderNameValidatorInterface
	 */
	private $headerNameValidator;
	/**
	 * @var HeaderValueValidatorInterface
	 */
	private $headerValueValidator;
	/**
	 * @var ProtocolVersionValidatorInterface
	 */
	private $protocolVersionValidator;
	/**
	 * @var HeaderValueFilterInterface
	 */
	private $headerValueFilter;
	/**
	 * @var MessageStreamValidatorInterface
	 */
	private $streamValidator;
	/**
	 * @var StreamFactoryInterface
	 */
	private $streamFactory;
	/**
	 * @var MethodValidatorInterface
	 */
	private $methodValidator;
	/**
	 * @var RequestTargetValidatorInterface
	 */
	private $requestTargetValidator;

	/**
	 * RequestFactory constructor.
	 * @param HeaderNameValidatorInterface      $headerNameValidator
	 * @param HeaderValueValidatorInterface     $headerValueValidator
	 * @param ProtocolVersionValidatorInterface $protocolVersionValidator
	 * @param MethodValidatorInterface          $methodValidator
	 * @param RequestTargetValidatorInterface   $requestTargetValidator
	 * @param HeaderValueFilterInterface        $headerValueFilter
	 */
	public function __construct(
		HeaderNameValidatorInterface $headerNameValidator,
		HeaderValueValidatorInterface $headerValueValidator,
		ProtocolVersionValidatorInterface $protocolVersionValidator,
		HeaderValueFilterInterface $headerValueFilter,
		MessageStreamValidatorInterface $streamValidator,
		StreamFactoryInterface $streamFactory,
		MethodValidatorInterface $methodValidator,
		RequestTargetValidatorInterface $requestTargetValidator
	)
	{
		$this->headerNameValidator      = $headerNameValidator;
		$this->headerValueValidator     = $headerValueValidator;
		$this->protocolVersionValidator = $protocolVersionValidator;
		$this->headerValueFilter        = $headerValueFilter;
		$this->streamValidator          = $streamValidator;
		$this->streamFactory            = $streamFactory;
		$this->methodValidator          = $methodValidator;
		$this->requestTargetValidator   = $requestTargetValidator;
	}

	public function createRequest(string $method, $uri): RequestInterface
	{
		$request = new Request($this->headerNameValidator,
			$this->headerValueValidator,
			$this->protocolVersionValidator,
			$this->headerValueFilter,
			$this->streamValidator,
			$this->streamFactory,
			$this->methodValidator,
			$this->requestTargetValidator);
		return $request
			->withMethod($method)
			->withUri($uri);
	}
}