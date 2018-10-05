<?php

namespace Qdt01\AgRest\Authentication;

use Qdt01\AgRest\Connector\ConnectorInterface;

/**
 * Abstract class AbstractAuthentication
 *
 * @package \Qdt01\AgRest\Authentication
 */
abstract class AbstractAuthorization implements AuthorizationInterface
{
	//region Fields
	/**
	 * TODO: Think about it twice
	 */
	/** @var ConnectorInterface */
	protected $httpClient;
	//endregion

	//region Constructor
	/**
	 * AbstractAuthentication constructor.
	 * @param ConnectorInterface $httpClient
	 */
	public function __construct(ConnectorInterface $httpClient)
	{
		$this->httpClient = $httpClient;
	}
	//endregion


}