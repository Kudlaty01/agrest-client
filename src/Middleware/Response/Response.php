<?php

namespace Qdt01\AgRest\Middleware\Response;

use Psr\Http\Message\{ResponseInterface, StreamFactoryInterface, StreamInterface};
use Qdt01\AgRest\Middleware\{AbstractMessage,
	Filters\Message\HeaderValueFilterInterface,
	Stream\Stream,
	Validators\Message\HeaderNameValidatorInterface,
	Validators\Message\HeaderValueValidatorInterface,
	Validators\Message\ProtocolVersionValidatorInterface,
	Validators\Message\MessageStreamValidatorInterface,
	Validators\Response\StatusCode\ReasonPhraseValidatorInterface,
	Validators\Response\StatusCode\StatusCodeValidatorInterface};

/**
 * Class Response. Would be abstract if only not the factory interface
 * @package Qdt01\AgRest\Middleware\Response
 */
class Response extends AbstractMessage implements ResponseInterface
{

	/**
	 * Map of standard HTTP status code/reason phrases
	 *
	 * @var array
	 */
	private $phrases = [
		//  1xx Informational
		100 => "Continue",
		101 => "Switching Protocols",
		102 => "Processing",
		//  2xx Success
		200 => "OK",
		201 => "Created",
		202 => "Accepted",
		203 => "Non-authoritative Information",
		204 => "No Content",
		205 => "Reset Content",
		206 => "Partial Content",
		207 => "Multi-Status",
		208 => "Already Reported",
		226 => "IM Used",
		//  3xx Redirection
		300 => "Multiple Choices",
		301 => "Moved Permanently",
		302 => "Found",
		303 => "See Other",
		304 => "Not Modified",
		305 => "Use Proxy",
		307 => "Temporary Redirect",
		308 => "Permanent Redirect",
		//  4xx Client Error
		400 => "Bad Request",
		401 => "Unauthorized",
		402 => "Payment Required",
		403 => "Forbidden",
		404 => "Not Found",
		405 => "Method Not Allowed",
		406 => "Not Acceptable",
		407 => "Proxy Authentication Required",
		408 => "Request Timeout",
		409 => "Conflict",
		410 => "Gone",
		411 => "Length Required",
		412 => "Precondition Failed",
		413 => "Payload Too Large",
		414 => "Request-URI Too Long",
		415 => "Unsupported Media Type",
		416 => "Requested Range Not Satisfiable",
		417 => "Expectation Failed",
		418 => "I'm a teapot",
		421 => "Misdirected Request",
		422 => "Unprocessable Entity",
		423 => "Locked",
		424 => "Failed Dependency",
		426 => "Upgrade Required",
		428 => "Precondition Required",
		429 => "Too Many Requests",
		431 => "Request Header Fields Too Large",
		444 => "Connection Closed Without Response",
		451 => "Unavailable For Legal Reasons",
		499 => "Client Closed Request",
		//  5xx Server Error
		500 => "Internal Server Error",
		501 => "Not Implemented",
		502 => "Bad Gateway",
		503 => "Service Unavailable",
		504 => "Gateway Timeout",
		505 => "HTTP Version Not Supported",
		506 => "Variant Also Negotiates",
		507 => "Insufficient Storage",
		508 => "Loop Detected",
		510 => "Not Extended",
		511 => "Network Authentication Required",
		599 => "Network Connect Timeout Error",
	];

	/**
	 * @var string
	 */
	private $reasonPhrase;

	/**
	 * @var int
	 */
	private $statusCode;
	/**
	 * @var StatusCodeValidatorInterface
	 */
	private $statusCodeValidator;
	/**
	 * @var ReasonPhraseValidatorInterface
	 */
	private $reasonPhraseValidator;

	/**
	 * Response constructor.
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

		parent::__construct($protocolVersionValidator,
			$headerNameValidator,
			$headerValueValidator,
			$headerValueFilter,
			$streamValidator,
			$streamFactory);
		$this->statusCodeValidator   = $statusCodeValidator;
		$this->reasonPhraseValidator = $reasonValidator;
	}


	/**
	 * @param string|resource|StreamInterface $body Stream identifier and/or actual stream resource
	 * @param int                             $status Status code for the response, if any.
	 * @param array                           $headers Headers for the response, if any.
	 * @return ResponseInterface
	 * @throws \InvalidArgumentException on any invalid element.
	 */
	public function initialize($body = 'php://memory', int $status = 200, array $headers = []): ResponseInterface
	{
		$this->setStatusCode($status);
		$this->stream = $this->getStream($body, Stream::MODE_READ_WRITE_RESET);
		$this->setHeaders($headers);
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getStatusCode(): int
	{
		return $this->statusCode;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getReasonPhrase(): string
	{
		return $this->reasonPhrase;
	}

	/**
	 * {@inheritdoc}
	 */
	public function withStatus($code, $reasonPhrase = ''): Response
	{
		$clone = clone $this;
		$clone->setStatusCode($code, $reasonPhrase);
		return $clone;
	}

	/**
	 * Set a valid status code.
	 *
	 * @param int    $code
	 * @param string $reasonPhrase
	 * @throws \InvalidArgumentException on an invalid status code.
	 */
	protected function setStatusCode($code, $reasonPhrase = ''): void
	{
		$this->statusCodeValidator->validate($code);


		$this->reasonPhraseValidator->validate($reasonPhrase);

		if ($reasonPhrase === '' && isset($this->phrases[$code])) {
			$reasonPhrase = $this->phrases[$code];
		}

		$this->reasonPhrase = $reasonPhrase;
		$this->statusCode   = (int)$code;
	}


}
