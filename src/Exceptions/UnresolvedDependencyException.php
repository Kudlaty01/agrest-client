<?php

namespace Qdt01\AgRest\Exceptions;

use Throwable;

/**
 * Class UnresolvedDependencyException
 *
 * @package \Qdt01\AgRest\Exceptions
 */
class UnresolvedDependencyException extends \Exception
{
	/**
	 * UnresolvedDependencyException constructor.
	 * @param string    $dependency
	 * @param int       $code
	 * @param Throwable $previous
	 */
	public function __construct(string $dependency, int $code = 0, Throwable $previous = null)
	{
		$message = sprintf(sprintf("Could not resolve %s dependency", $dependency));
		parent::__construct($message, $code, $previous);
	}


}