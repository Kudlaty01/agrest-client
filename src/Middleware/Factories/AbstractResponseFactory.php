<?php

namespace Qdt01\AgRest\Middleware\Factories;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Qdt01\AgRest\Middleware\Filters\Message\HeaderValueFilterInterface;
use Qdt01\AgRest\Middleware\Validators\Message\HeaderNameValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Message\HeaderValueValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Message\ProtocolVersionValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Message\MessageStreamValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Response\StatusCode\ReasonPhraseValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Response\StatusCode\StatusCodeValidatorInterface;

/**
 * Class AbstractResponseFactory
 *
 * @package \Qdt01\AgRest\Middleware\Factories
 */
abstract class AbstractResponseFactory implements ResponseFactoryInterface
{
	/**
	 * @var HeaderValueValidatorInterface
	 */
	protected $headerValueValidator;
	/**
	 * @var ReasonPhraseValidatorInterface
	 */
	protected $reasonValidator;
	/**
	 * @var StatusCodeValidatorInterface
	 */
	protected $statusCodeValidator;
	/**
	 * @var StreamFactoryInterface
	 */
	protected $streamFactory;
	/**
	 * @var HeaderNameValidatorInterface
	 */
	protected $headerNameValidator;
	/**
	 * @var HeaderValueFilterInterface
	 */
	protected $headerValueFilter;
	/**
	 * @var MessageStreamValidatorInterface
	 */
	protected $streamValidator;
	/**
	 * @var ProtocolVersionValidatorInterface
	 */
	protected $protocolVersionValidator;

	/**
	 * ResponseFactory constructor.
	 * @param ProtocolVersionValidatorInterface $protocolVersionValidator
	 * @param HeaderNameValidatorInterface      $headerNameValidator
	 * @param HeaderValueValidatorInterface     $headerValueValidator
	 * @param HeaderValueFilterInterface        $headerValueFilter
	 * @param MessageStreamValidatorInterface   $streamValidator
	 * @param StreamFactoryInterface            $streamFactory
	 * @param StatusCodeValidatorInterface      $statusCodeValidator
	 * @param ReasonPhraseValidatorInterface    $reasonValidator
	 */
	public function __construct(
		ProtocolVersionValidatorInterface $protocolVersionValidator,
		HeaderNameValidatorInterface $headerNameValidator,
		HeaderValueValidatorInterface $headerValueValidator,
		HeaderValueFilterInterface $headerValueFilter,
		MessageStreamValidatorInterface $streamValidator,
		StreamFactoryInterface $streamFactory,
		StatusCodeValidatorInterface $statusCodeValidator,
		ReasonPhraseValidatorInterface $reasonValidator)
	{

		$this->protocolVersionValidator = $protocolVersionValidator;
		$this->headerNameValidator      = $headerNameValidator;
		$this->headerValueValidator     = $headerValueValidator;
		$this->headerValueFilter        = $headerValueFilter;
		$this->streamValidator          = $streamValidator;
		$this->streamFactory            = $streamFactory;
		$this->statusCodeValidator      = $statusCodeValidator;
		$this->reasonValidator          = $reasonValidator;
	}
}