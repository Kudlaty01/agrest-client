<?php

namespace Qdt01\AgRest\Adapters;

use Psr\Http\Message\ResponseInterface;

interface ResponseAdapterInterface
{
	function getResponse(): ResponseInterface;

}