<?php

namespace Qdt01\AgRest\Models;

interface ModelArrayAdapterInterface
{
	function fromArray(array $array): void;

	function toArray(): array;

}