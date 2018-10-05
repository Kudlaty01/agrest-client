<?php

namespace Qdt01\AgRest\Middleware\Filters\Message;


use Qdt01\AgRest\Middleware\Validators\Message\HeaderValueValidatorInterface;

/**
 * Class HeaderValuesFilter for header values filtering
 *
 * @package \Qdt01\AgRest\Validators
 */
class HeaderValueFilter implements HeaderValueFilterInterface
{
	/**
	 * @var HeaderValueValidatorInterface
	 */
	private $headerValueValidator;


	/**
	 * HeaderValuesFilter constructor.
	 * @param HeaderValueValidatorInterface $headerValueValidator
	 */
	public function __construct(HeaderValueValidatorInterface $headerValueValidator)
	{
		$this->headerValueValidator = $headerValueValidator;
	}

	/**
	 * @param mixed $values
	 * @return string[]
	 */
	public function filter($values): array
	{
		if (!is_array($values)) {
			$values = [$values];
		}

		if ([] === $values) {
			throw new \InvalidArgumentException(
				'Invalid header value: must be a string or array of strings; '
				. 'cannot be an empty array'
			);
		}

		return array_map(function ($value) {
			$this->headerValueValidator->validate($value);
			return strval($value);
		}, array_values($values));
	}
}