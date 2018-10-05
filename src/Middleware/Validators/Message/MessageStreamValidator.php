<?php

namespace Qdt01\AgRest\Middleware\Validators\Message;

use Psr\Http\Message\StreamInterface;

/**
 * Class StreamValidator
 *
 * @package \Qdt01\AgRest\Middleware\Validators\Message
 */
class MessageStreamValidator implements MessageStreamValidatorInterface
{

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public function validate($value): void
	{
		if (!is_string($value) && !is_resource($value)) {
			throw new \InvalidArgumentException(
				sprintf('Stream must be a string stream resource identifier, an actual stream resource, or a %s implementation', StreamInterface::class)
			);
		}
	}
}