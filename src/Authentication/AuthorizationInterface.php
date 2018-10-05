<?php

namespace Qdt01\AgRest\Authentication;

use Psr\Http\Message\RequestInterface;

/**
 * Interface AuthenticationInterface
 *
 * @package \Qdt01\AgRest\Authentication
 */
interface AuthorizationInterface
{
	function authorize(RequestInterface $request);

}