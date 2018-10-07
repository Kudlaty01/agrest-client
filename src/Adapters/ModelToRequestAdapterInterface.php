<?php

namespace Qdt01\AgRest\Adapters;

use Psr\Http\Message\RequestInterface;

interface ModelToRequestAdapterInterface
{
	function getRequest(RequestInterface $request): RequestInterface;

}