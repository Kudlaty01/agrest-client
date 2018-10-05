<?php

namespace Qdt01\AgRest\Client;

use Qdt01\AgRest\ApiCalls\{ApiCallResultInterface, CommandApiCallInterface, QueryApiCallInterface};

interface RestClientInterface
{
	/**
	 * perform a query retrieving data
	 * @param QueryApiCallInterface $queryApiCall
	 * @return ApiCallResultInterface
	 */
	public function get(QueryApiCallInterface $queryApiCall): ApiCallResultInterface;

	/**
	 * execute a data modifying command
	 * @param CommandApiCallInterface $commandApiCall
	 * @return ApiCallResultInterface
	 */
	public function exec(CommandApiCallInterface $commandApiCall): ApiCallResultInterface;
}