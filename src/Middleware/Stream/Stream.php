<?php

namespace Qdt01\AgRest\Middleware\Stream;

use Psr\Http\Message\StreamInterface;
use Qdt01\AgRest\Middleware\Validators\Stream\StreamValidatorInterface;

/**
 * Class Stream
 *
 * @package \Qdt01\AgRest\Middleware
 */
class Stream implements StreamInterface
{
	const MODE_READ_ONLY_FROM_BEGIN = 'rb';

	const MODE_READ_WRITE_FROM_BEGIN = 'r+b';

	const MODE_WRITE_ONLY_RESET = 'wb';

	const MODE_READ_WRITE_RESET = 'wb+';

	const MODE_WRITE_ONLY_FROM_END = 'ab';

	const MODE_READ_WRITE_FROM_END = 'ab+';

	const MODE_READ_ONLY = 'r';

	const MODE_READ_WRITE = 'r+';

	/**
	 * @var resource
	 */
	protected $resource;

	/**
	 * @var string|resource
	 */
	protected $stream;
	/**
	 * @var StreamValidatorInterface
	 */
	private $streamValidator;

	/**
	 * Class init.
	 *
	 * @param StreamValidatorInterface $streamValidator
	 */
	public function __construct(StreamValidatorInterface $streamValidator)
	{
		$this->streamValidator = $streamValidator;
	}

	public function __toString(): string
	{
		if (!$this->isReadable()) {
			return '';
		}

		try {
			$this->rewind();

			return $this->getContents();
		} catch (\Exception $e) {
			return (string)$e;
		}
	}

	public function close(): void
	{
		if (!$this->resource) {
			return;
		}

		$resource = $this->detach();

		fclose($resource);
	}

	/**
	 * @param string|resource $stream
	 * @param string          $mode
	 * @return StreamInterface
	 */
	public function attach($stream, $mode = self::MODE_READ_ONLY): StreamInterface
	{
		$this->streamValidator->validate($stream);
		$this->stream = $stream;

		if (is_resource($stream)) {
			$this->resource = $stream;
		} elseif (is_string($stream)) {
			$this->resource = fopen($stream, $mode);
		}

		return $this;
	}

	/**
	 * @return null|resource
	 */
	public function detach()
	{
		$resource = $this->resource;

		$this->resource = null;
		$this->stream   = null;

		return $resource;
	}

	public function getSize(): ?int
	{
		if (!is_resource($this->resource)) {
			return null;
		}

		$stats = fstat($this->resource);

		return $stats['size'];
	}

	/**
	 * @return bool|int
	 */
	public function tell()
	{
		if (!is_resource($this->resource)) {
			throw new \RuntimeException('No resource available.');
		}

		$result = ftell($this->resource);

		if (!is_int($result)) {
			throw new \RuntimeException('Error occurred during tell operation');
		}

		return $result;
	}

	public function eof(): bool
	{
		if (!is_resource($this->resource)) {
			return true;
		}

		return feof($this->resource);
	}

	public function isSeekable(): bool
	{
		if (!is_resource($this->resource)) {
			return false;
		}

		$meta = stream_get_meta_data($this->resource);

		return $meta['seekable'];
	}

	public function seek($offset, $whence = SEEK_SET): bool
	{
		if (!is_resource($this->resource)) {
			throw new \RuntimeException('No resource available.');
		}

		if (!$this->isSeekable()) {
			throw new \RuntimeException('Stream is not seekable');
		}

		$result = fseek($this->resource, $offset, $whence);

		if ($result !== 0) {
			throw new \RuntimeException('Error seeking within stream');
		}

		return true;
	}

	public function rewind(): bool
	{
		return $this->seek(0);
	}

	public function isWritable(): bool
	{
		if (!is_resource($this->resource)) {
			return false;
		}

		$meta = stream_get_meta_data($this->resource);

		return is_writable($meta['uri']);
	}

	/**
	 * @param string $string
	 * @return bool|int
	 */
	public function write($string)
	{
		if (!is_resource($this->resource)) {
			throw new \RuntimeException('No resource available.');
		}

		$result = fwrite($this->resource, $string);

		if ($result === false) {
			throw new \RuntimeException('Error writing to stream');
		}

		return $result;
	}

	public function isReadable(): bool
	{
		if (!is_resource($this->resource)) {
			return false;
		}

		$meta = stream_get_meta_data($this->resource);
		$mode = $meta['mode'];

		return (strstr($mode, 'r') || strstr($mode, '+'));
	}

	/**
	 * @param int $length
	 * @return bool|string
	 */
	public function read($length)
	{
		if (!is_resource($this->resource)) {
			throw new \RuntimeException('No resource available.');
		}

		if (!$this->isReadable()) {
			throw new \RuntimeException('Stream is not readable');
		}

		$result = fread($this->resource, $length);

		if ($result === false) {
			throw new \RuntimeException('Error reading stream');
		}

		return $result;
	}

	/**
	 * @return bool|string
	 */
	public function getContents()
	{
		if (!$this->isReadable()) {
			return '';
		}

		$result = stream_get_contents($this->resource);

		if ($result === false) {
			throw new \RuntimeException('Error reading from stream');
		}

		return $result;
	}

	/**
	 * @param string|int|null $key
	 * @return array|mixed|null
	 */
	public function getMetadata($key = null)
	{
		$metadata = stream_get_meta_data($this->resource);

		if ($key === null) {
			return $metadata;
		}

		if (!array_key_exists($key, $metadata)) {
			return null;
		}

		return $metadata[$key];
	}

	/**
	 * @return resource
	 */
	public function getResource()
	{
		return $this->resource;
	}

}
