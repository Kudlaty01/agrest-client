<?php

namespace Qdt01\AgRest\Middleware\Stream;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Qdt01\AgRest\Middleware\Validators\Stream\ResourceValidatorInterface;
use Qdt01\AgRest\Middleware\Validators\Stream\StreamValidatorInterface;

/**
 * Class StreamFactory
 *
 * @package \Qdt01\AgRest\Middleware\Stream\Stream
 */
class StreamFactory implements StreamFactoryInterface
{
	/**
	 * @var StreamValidatorInterface
	 */
	private $streamValidator;
	/**
	 * @var ResourceValidatorInterface
	 */
	private $resourceValidator;

	/**
	 * StreamFactory constructor.
	 * @param StreamValidatorInterface $streamResourceValidator
	 */
	public function __construct(StreamValidatorInterface $streamResourceValidator,
	                            ResourceValidatorInterface $resourceValidator)
	{
		$this->streamValidator   = $streamResourceValidator;
		$this->resourceValidator = $resourceValidator;
	}


	/**
	 * {@inheritDoc}
	 */
	public function createStream(string $content = ''): StreamInterface
	{
		$resource = fopen('php://temp', Stream::MODE_READ_WRITE);
		fwrite($resource, $content);
		rewind($resource);

		return $this->createStreamFromResource($resource);
	}

	/**
	 * {@inheritDoc}
	 */
	public function createStreamFromFile(string $file, string $mode = 'r'): StreamInterface
	{
		$stream = new Stream($this->streamValidator);
		return $stream->attach($file, $mode);
	}

	/**
	 * {@inheritDoc}
	 */
	public function createStreamFromResource($resource): StreamInterface
	{
		$this->resourceValidator->validate($resource);
		$stream = new Stream($this->streamValidator);
		return $stream->attach($resource);
	}
}