<?php

namespace Qdt01\AgRest\Middleware\Factories;

interface UriFactoryInterface
{
	function createUri(string $address);
}