<?php

namespace Qdt01\AgRest\Middleware\Stream;

/**
 * Class StreamMetaData
 *
 * @package \Qdt01\AgRest\Middleware\Stream\Stream
 */
class StreamMetaData
{
	//region Fields
	/**
	 * @var string
	 */
	protected $wrapper_type;
	/**
	 * @var string
	 */
	protected $stream_type;
	/**
	 * @var string
	 */
	protected $mode;
	/**
	 * @var int
	 */
	protected $unread_bytes;
	/**
	 * @var bool
	 */
	protected $seekable;
	/**
	 * @var string
	 */
	protected $uri;
	/**
	 * @var bool
	 */
	protected $timed_out;
	/**
	 * @var bool
	 */
	protected $blocked;
	/**
	 * @var bool
	 */
	protected $eof;

	//endregion

	//region Methods
	/**
	 * @param string $key
	 * @return string|int|bool
	 */
	public function get(string $key)
	{
		if (!property_exists($this, $key)) {
			throw new \InvalidArgumentException(sprintf('There is no such property as %s!', $key));

		}
		return $this->$key;
	}
	//region Getters and setters

	/**
	 * @return string
	 */
	public function getWrapperType(): string
	{
		return $this->wrapper_type;
	}

	/**
	 * @param string $wrapper_type
	 * @return StreamMetaData
	 */
	public function setWrapperType(string $wrapper_type): StreamMetaData
	{
		$this->wrapper_type = $wrapper_type;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getStreamType(): string
	{
		return $this->stream_type;
	}

	/**
	 * @param string $stream_type
	 * @return StreamMetaData
	 */
	public function setStreamType(string $stream_type): StreamMetaData
	{
		$this->stream_type = $stream_type;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMode(): string
	{
		return $this->mode;
	}

	/**
	 * @param string $mode
	 * @return StreamMetaData
	 */
	public function setMode(string $mode): StreamMetaData
	{
		$this->mode = $mode;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getUnreadBytes(): int
	{
		return $this->unread_bytes;
	}

	/**
	 * @param int $unread_bytes
	 * @return StreamMetaData
	 */
	public function setUnreadBytes(int $unread_bytes): StreamMetaData
	{
		$this->unread_bytes = $unread_bytes;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isSeekable(): bool
	{
		return $this->seekable;
	}

	/**
	 * @param bool $seekable
	 * @return StreamMetaData
	 */
	public function setSeekable(bool $seekable): StreamMetaData
	{
		$this->seekable = $seekable;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUri(): string
	{
		return $this->uri;
	}

	/**
	 * @param string $uri
	 * @return StreamMetaData
	 */
	public function setUri(string $uri): StreamMetaData
	{
		$this->uri = $uri;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isTimedOut(): bool
	{
		return $this->timed_out;
	}

	/**
	 * @param bool $timed_out
	 * @return StreamMetaData
	 */
	public function setTimedOut(bool $timed_out): StreamMetaData
	{
		$this->timed_out = $timed_out;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isBlocked(): bool
	{
		return $this->blocked;
	}

	/**
	 * @param bool $blocked
	 * @return StreamMetaData
	 */
	public function setBlocked(bool $blocked): StreamMetaData
	{
		$this->blocked = $blocked;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isEof(): bool
	{
		return $this->eof;
	}

	/**
	 * @param bool $eof
	 * @return StreamMetaData
	 */
	public function setEof(bool $eof): StreamMetaData
	{
		$this->eof = $eof;
		return $this;
	}

	//endregion
	//endregion


}