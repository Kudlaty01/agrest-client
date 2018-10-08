<?php

namespace Qdt01\AgRest\Middleware\Factories;

use Psr\Http\Message\UriInterface;

interface UriFactoryInterface
{
	function createUri(string $address): UriInterface;
}