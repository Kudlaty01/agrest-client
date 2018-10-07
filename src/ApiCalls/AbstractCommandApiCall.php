<?php

namespace Qdt01\AgRest\ApiCalls;

use Qdt01\AgRest\Adapters\ModelToRequestAdapterInterface;

/**
 * Class AbstractCommandApiCall
 *
 * @package \Qdt01\AgRest\ApiCalls
 */
abstract class AbstractCommandApiCall implements CommandApiCallInterface
{
	/**
	 * @var ModelToRequestAdapterInterface
	 */
	protected $modelToRequestAdapter;
}