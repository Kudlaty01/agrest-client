<?php

namespace Qdt01\AgRest\Modules\ISystems\Domains;

use Qdt01\AgRest\Domains\AbstractModelDomain;

/**
 * Class ProducerSpace
 *
 * @package \Qdt01\AgRest\Modules\ISystems\Domains
 */
class ProducerModelDomain extends AbstractModelDomain
{
	function getDomainAddressFragment(): string
	{
		return '/producers';
	}
}