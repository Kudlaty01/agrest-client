<?php

namespace Qdt01\AgRest\Adapters;

use Psr\Http\Message\ResponseInterface;

/**
 * Class AbstractResponseToModelAdapter
 *
 * @package \Qdt01\AgRest\Adapters
 */
abstract class AbstractResponseToModelAdapter implements ResponseToModelAdapterInterface
{
	/**
	 * @var ResponseInterface
	 */
	protected $response;

	/**
	 * AbstractResponseToModelAdapter constructor.
	 * @param ResponseInterface $response
	 */
	public function __construct(ResponseInterface $response)
	{
		$this->response = $response;
	}
}