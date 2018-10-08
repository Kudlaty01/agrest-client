<?php

namespace Qdt01\AgRest\Middleware\Request;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriInterface;
use Qdt01\AgRest\Middleware\{AbstractMessage,
	Filters\Message\HeaderValueFilterInterface,
	Validators\Message\HeaderNameValidatorInterface,
	Validators\Message\HeaderValueValidatorInterface,
	Validators\Message\MessageStreamValidatorInterface,
	Validators\Message\ProtocolVersionValidatorInterface,
	Validators\Request\MethodValidatorInterface,
	Validators\Request\RequestTargetValidator,
	Validators\Request\RequestTargetValidatorInterface};

/**
 * Class AbstractRequest
 *
 * @method getProtocolVersion(): string
 * @package \Qdt01\AgRest\Middleware
 */
class Request extends AbstractMessage implements RequestInterface
{
	const URI_QUERY_PART_SEPARATOR = '?';

	const EMPTY_REQUEST_TARGET = '/';
	//region Fields
	/** @var string */
	protected $method;

	/** @var null|string */
	protected $requestTarget;

	/** @var UriInterface */
	protected $uri;

	/** @var RequestTargetValidator */
	protected $requestTargetValidator;
	/**
	 * @var MethodValidatorInterface
	 */
	protected $methodValidator;

	//endregion

	//region Constructor
	/**
	 * AbstractRequest constructor.
	 * @param HeaderNameValidatorInterface      $headerNameValidator
	 * @param HeaderValueValidatorInterface     $headerValueValidator
	 * @param ProtocolVersionValidatorInterface $protocolVersionValidator
	 * @param HeaderValueFilterInterface        $headerValueFilter
	 * @param MessageStreamValidatorInterface   $streamValidator
	 * @param StreamFactoryInterface            $streamFactory
	 * @param MethodValidatorInterface          $methodValidator
	 * @param RequestTargetValidatorInterface   $requestTargetValidator
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
		parent::__construct($protocolVersionValidator,
			$headerNameValidator,
			$headerValueValidator,
			$headerValueFilter,
			$streamValidator,
			$streamFactory);
		$this->methodValidator        = $methodValidator;
		$this->requestTargetValidator = $requestTargetValidator;
	}

//endregion


//region Methods

	public
	function getRequestTarget(): ?string
	{
		if (null !== $this->requestTarget) {
			return $this->requestTarget;
		}

		$requestTarget = $this->uri->getPath();
		if ($this->uri->getQuery()) {
			$requestTarget .= self::URI_QUERY_PART_SEPARATOR . $this->uri->getQuery();
		}

		if (empty($requestTarget)) {
			$requestTarget = self::EMPTY_REQUEST_TARGET;
		}

		return $requestTarget;
	}

	public
	function withRequestTarget($requestTarget): self
	{
		$this->requestTargetValidator->validate($requestTarget);

		$clone                = clone $this;
		$clone->requestTarget = $requestTarget;
		return $clone;
	}

	public
	function getMethod(): string
	{
		return $this->method;
	}

	public
	function withMethod($method): self
	{
		$this->methodValidator->validate($method);
		$clone         = clone $this;
		$clone->method = $method;
		return $clone;
	}

	public
	function getUri(): UriInterface
	{
		return $this->uri;
	}

	public
	function withUri(UriInterface $uri, $preserveHost = false): self
	{
		$clone      = clone $this;
		$clone->uri = $uri;

		if ($preserveHost && $this->hasHeader('Host')) {
			return $clone;
		}

		if (!$uri->getHost()) {
			return $clone;
		}

		$host = $uri->getHost();
		if ($uri->getPort()) {
			$host .= ':' . $uri->getPort();
		}

		$clone->headerNames['host'] = 'Host';

		foreach (array_keys($clone->headers) as $header) {
			if (strtolower($header) === 'host') {
				unset($clone->headers[$header]);
			}
		}

		$clone->headers['Host'] = [$host];

		return $clone;
	}

//endregion


}