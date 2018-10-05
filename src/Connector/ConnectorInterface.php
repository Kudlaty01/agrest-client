<?php

namespace Qdt01\AgRest\Connector;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ConnectorInterface
{
	function send(RequestInterface $request): ResponseInterface;
}