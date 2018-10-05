<?php

namespace Qdt01\AgRest\Middleware;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Qdt01\AgRest\Middleware\Filters\Message\HeaderValueFilterInterface;
use Qdt01\AgRest\Middleware\Validators\Message\HeaderNameValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Message\HeaderValueValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Message\ProtocolVersionValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Message\MessageStreamValidatorInterface;

/**
 * Class AbstractMessage
 *
 * @package \Qdt01\AgRest\Middleware
 */
class AbstractMessage implements MessageInterface
{
	//region Fields
	/** @var string */
	protected $protocolVersion = '1.1';
	/** @var array */
	protected $headers = [];
	/** @var array */
	protected $headerNames = [];
	/** @var StreamInterface */
	protected $stream;
	/** @var ProtocolVersionValidatorInterface */
	private $protocolVersionValidator;
	/** @var HeaderNameValidatorInterface */
	private $headerNameValidator;
	/** @var HeaderValueValidatorInterface */
	private $headerValueValidator;
	/** @var HeaderValueFilterInterface */
	protected $headerValueFilter;
	/** * @var MessageStreamValidatorInterface */
	private $streamValidator;


	//region Constants
	const HEADERS_SEPARATOR = ', ';
	/**
	 * @var StreamFactoryInterface
	 */
	private $streamFactory;

	//endregion
	//endregion
	//region Constructor

	/**
	 * AbstractMessage constructor.
	 * @param ProtocolVersionValidatorInterface $protocolVersionValidator
	 * @param HeaderNameValidatorInterface      $headerNameValidator
	 * @param HeaderValueValidatorInterface     $headerValueValidator
	 * @param HeaderValueFilterInterface        $headerValueFilter
	 * @param MessageStreamValidatorInterface   $streamValidator
	 * @param StreamFactoryInterface            $streamFactory
	 */
	public function __construct(
		ProtocolVersionValidatorInterface $protocolVersionValidator,
		HeaderNameValidatorInterface $headerNameValidator,
		HeaderValueValidatorInterface $headerValueValidator,
		HeaderValueFilterInterface $headerValueFilter,
		MessageStreamValidatorInterface $streamValidator,
		StreamFactoryInterface $streamFactory
	)
	{
		$this->protocolVersionValidator = $protocolVersionValidator;
		$this->headerNameValidator      = $headerNameValidator;
		$this->headerValueValidator     = $headerValueValidator;
		$this->headerValueFilter        = $headerValueFilter;
		$this->streamValidator          = $streamValidator;
		$this->streamFactory            = $streamFactory;
	}


	//endregion

	//region Methods
	public function getProtocolVersion(): string
	{
		return $this->protocolVersion;
	}

	public function withProtocolVersion($version): self
	{
		if ($this->protocolVersion === $version) {
			return $this;
		}
		$this->protocolVersionValidator->validate($version);
		$clone                  = clone $this;
		$clone->protocolVersion = $version;
		return $clone;
	}

	public function getHeaders(): array
	{
		return $this->headers;
	}

	public function hasHeader($name): bool
	{
		return isset($this->headersNames[strtolower($name)]);
	}

	public function getHeader($name)
	{
		$name = strtolower($name);
		return isset($this->headerNames[$name]) ? $this->headers[$this->headerNames[$name]] : [];
	}

	public function getHeaderLine($name): string
	{
		return join(self::HEADERS_SEPARATOR, $this->getHeader($name));
	}

	public function withHeader($name, $value): self
	{
		$this->headerNameValidator->validate($name);
		$value = $this->headerValueFilter->filter($value);

		$normalized = strtolower($name);

		$clone = clone $this;
		if ($clone->hasHeader($normalized)) {
			unset($clone->headers[$clone->headerNames[$normalized]]);
		}
		$clone->headerNames[$normalized] = $name;
		$clone->headers[$name]           = $value;

		return $clone;
	}

	public function withAddedHeader($name, $value): self
	{

		if (!$this->hasHeader($name)) {
			return $this->withHeader($name, $value);
		}

		$name = $this->headerNames[strtolower($name)];

		$clone                 = clone $this;
		$value                 = $this->headerValueFilter->filter($value);
		$clone->headers[$name] = array_merge($this->headers[$name], $value);
		return $clone;
	}

	public function withoutHeader($name): self
	{
		$normalized = strtolower($name);

		if (!isset($this->headerNames[$normalized])) {
			return $this;
		}

		$name = $this->headerNames[$normalized];

		$clone = clone $this;
		unset($clone->headers[$name], $clone->headerNames[$normalized]);

		return $clone;
	}

	public function getBody(): StreamInterface
	{
		return $this->stream;
	}

	public function withBody(StreamInterface $body)
	{
		$clone         = clone $this;
		$clone->stream = $body;
		return $clone;
	}

	protected function setHeaders(array $originalHeaders): void
	{
		$headerNames = $headers = [];

		foreach ($originalHeaders as $header => $value) {
			$value = $this->headerValueFilter->filter($value);

			$this->headerNameValidator->validate($header);

			$headerNames[strtolower($header)] = $header;
			$headers[$header]                 = $value;
		}

		$this->headerNames = $headerNames;
		$this->headers     = $headers;
	}

	/**
	 * @param string|resource|StreamInterface $stream
	 * @param string                          $modeIfNotInstance
	 * @return StreamInterface
	 */
	protected function getStream($stream, string $modeIfNotInstance): StreamInterface
	{
		if ($stream instanceof StreamInterface) {
			return $stream;
		}

		$this->streamValidator->validate($stream);

		if (is_string($stream)) {
			$stream = $this->streamFactory->createStreamFromFile($stream, $modeIfNotInstance);
		} elseif (is_resource($stream)) {
			$this->streamFactory->createStreamFromResource($stream);
		}

		return new $stream;
	}
	//endregion


}