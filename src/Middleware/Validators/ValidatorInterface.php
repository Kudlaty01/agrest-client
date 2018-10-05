<?php

namespace Qdt01\AgRest\Middleware\Validators;

interface ValidatorInterface
{

	/**
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public function validate($value): void;
}