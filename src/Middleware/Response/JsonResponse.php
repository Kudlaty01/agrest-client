<?php

namespace Qdt01\AgRest\Middleware\Response;

use Psr\Http\Message\{ResponseInterface, StreamFactoryInterface, StreamInterface};
use Qdt01\AgRest\Middleware\{Filters\Message\HeaderValueFilterInterface,
	Stream\Stream,
	Validators\Message\HeaderNameValidatorInterface,
	Validators\Message\HeaderValueValidatorInterface,
	Validators\Message\MessageStreamValidatorInterface,
	Validators\Message\ProtocolVersionValidatorInterface,
	Validators\Response\StatusCode\ReasonPhraseValidatorInterface,
	Validators\Response\StatusCode\StatusCodeValidatorInterface};

class JsonResponse extends ContentTypeResponse
{

	/** @const default flag for json_decode */
	const DEFAULT_JSON_FLAGS = 79;

	/** * @var mixed */
	private $payload;

	/** * @var int */
	private $encodingOptions = self::DEFAULT_JSON_FLAGS;

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
			$streamFactory,
			$statusCodeValidator,
			$reasonValidator);
	}

	public function initialize(
		$data = 'php://memory',
		int $status = 200,
		array $headers = []
	): ResponseInterface
	{
		$this->setPayload($data);

		$json = $this->jsonEncode($data, $this->encodingOptions);
		$body = $this->createBodyFromJson($json);

		$headers = $this->setContentType('application/json', $headers);
		parent::initialize($data, $status, $headers);
		return $this;

	}

	/**
	 * @return mixed
	 */
	public function getPayload()
	{
		return $this->payload;
	}

	/**
	 * @param mixed $data
	 * @return JsonResponse
	 */
	public function withPayload($data): JsonResponse
	{
		$clone = clone $this;
		$clone->setPayload($data);
		return $this->updateBodyFor($clone);
	}

	public function getEncodingOptions(): int
	{
		return $this->encodingOptions;
	}

	public function withEncodingOptions(int $encodingOptions): JsonResponse
	{
		$clone                  = clone $this;
		$clone->encodingOptions = $encodingOptions;
		return $this->updateBodyFor($clone);
	}

	private function createBodyFromJson(string $json): StreamInterface
	{
		$mode = Stream::MODE_READ_WRITE_RESET;
		$body = $this->getStream(fopen('php://temp', $mode), $mode);
		$body->write($json);
		$body->rewind();

		return $body;
	}

	/**
	 * @param mixed $data
	 * @throws \InvalidArgumentException if unable to encode the $data to JSON.
	 */
	private function jsonEncode($data, int $encodingOptions): string
	{
		if (is_resource($data)) {
			throw new \InvalidArgumentException('Cannot JSON encode resources');
		}

		// Clear json_last_error()
		json_encode(null);

		$json = json_encode($data, $encodingOptions);

		if (JSON_ERROR_NONE !== json_last_error()) {
			throw new \InvalidArgumentException(sprintf(
				'Unable to encode data to JSON in %s: %s',
				__CLASS__,
				json_last_error_msg()
			));
		}

		return $json;
	}

	/**
	 * @param mixed $data
	 */
	private function setPayload($data): void
	{
		if (is_object($data)) {
			$data = clone $data;
		}

		$this->payload = $data;
	}

	/**
	 * Update the response body for the given instance.
	 *
	 * @param self $toUpdate Instance to update.
	 * @return JsonResponse Returns a new instance with an updated body.
	 */
	private function updateBodyFor(JsonResponse $toUpdate): JsonResponse
	{
		$json = $this->jsonEncode($toUpdate->payload, $toUpdate->encodingOptions);
		$body = $this->createBodyFromJson($json);
		return $toUpdate->withBody($body);
	}
}
