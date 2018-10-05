<?php

namespace Qdt01\AgRest\Middleware\Validators\Message;

/**
 * Class ProtocolVersionValidator
 *
 * @package \Qdt01\AgRest\Middleware\Validators\Message
 */
class ProtocolVersionValidator implements ProtocolVersionValidatorInterface
{

	/**
	 * Validate the HTTP protocol version
	 * explicit parameter type definition is omitted to avoid silent conversion
	 *
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public function validate($value): void
	{
		if (empty($version)) {
			throw new \InvalidArgumentException(
				'HTTP protocol version can not be empty'
			);
		}
		if (!is_string($version)) {
			throw new \InvalidArgumentException(sprintf(
				'Unsupported HTTP protocol version; must be a string, received %s',
				(is_object($version) ? get_class($version) : gettype($version))
			));
		}

		// HTTP/1 uses a "<major>.<minor>" numbering scheme to indicate
		// versions of the protocol, while HTTP/2 does not.
		if (!preg_match('#^(1\.[01]|2)$#', $version)) {
			throw new \InvalidArgumentException(sprintf(
				'Unsupported HTTP protocol version "%s" provided',
				$version
			));
		}
	}
}