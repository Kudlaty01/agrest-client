<?php

namespace Qdt01\AgRest\Middleware\Validators\Message;

/**
 * Class HeaderValueValidator
 *
 * @package \Qdt01\AgRest\Middleware\Validators\Message
 */
class HeaderValueValidator implements HeaderValueValidatorInterface
{

	/**
	 * Assert a header value is valid.
	 *
	 * @param mixed $value Value to be tested. This method asserts it is a string or number.
	 * @throws \InvalidArgumentException for invalid values
	 */
	public function validate($value): void
	{
		if (!is_string($value) && !is_numeric($value)) {
			throw new \InvalidArgumentException(sprintf(
				'Invalid header value type; must be a string or numeric; received %s',
				(is_object($value) ? get_class($value) : gettype($value))
			));
		}
		if (!$this->isValueValid($value)) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" is not valid header value',
				$value
			));
		}
	}

	/**
	 * Validate a header value.
	 *
	 * Per RFC 7230, only VISIBLE ASCII characters, spaces, and horizontal
	 * tabs are allowed in values; header continuations MUST consist of
	 * a single CRLF sequence followed by a space or horizontal tab.
	 *
	 * @param string|int|float $value
	 * @see http://en.wikipedia.org/wiki/HTTP_response_splitting
	 * @return bool
	 */
	private function isValueValid(string $value): bool
	{
		return !(
			// Look for:
			// \n not preceded by \r, OR
			// \r not followed by \n, OR
			// \r\n not followed by space or horizontal tab; these are all CRLF attacks
			preg_match("#(?:(?:(?<!\r)\n)|(?:\r(?!\n))|(?:\r\n(?![ \t])))#", $value)
			// Non-visible, non-whitespace characters
			// 9 === horizontal tab
			// 10 === line feed
			// 13 === carriage return
			// 32-126, 128-254 === visible
			// 127 === DEL (disallowed)
			// 255 === null byte (disallowed)
			|| preg_match('/[^\x09\x0a\x0d\x20-\x7E\x80-\xFE]/', $value)
		);
	}
}