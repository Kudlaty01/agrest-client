<?php

namespace Qdt01\AgRest\ApiCalls;

use Psr\Http\Message\RequestInterface;
use Qdt01\AgRest\Middleware\Request\RequestMethodInterface;

/**
 * Class AbstractQueryApiCall
 *
 * @package \Qdt01\AgRest\ApiCalls
 */
abstract class AbstractQueryApiCall extends AbstractApiCall implements QueryApiCallInterface
{

	public function getRequest(): RequestInterface
	{
		return $this->requestFactory->createRequest(RequestMethodInterface::METHOD_GET, join('/', array_filter([$this->baseEndpoint, $this->modelDomain->getDomainAddressFragment(), $this->model->getId()])));
	}

}