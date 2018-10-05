<?php

namespace Qdt01\AgRest\Services;

/**
 * Class AbstractModuleRoutes
 *
 * @package \Qdt01\AgRest\Services
 */
abstract class AbstractModuleRoutes
{
	const URL_PATH_SEPARATOR = '/';

	/**
	 * Update url fragment by prefixing with baseUrl
	 * @param string      $urlFragment
	 * @param null|string $baseUrl
	 * @return string
	 */
	protected function prependWithBaseUrl(string $urlFragment, ?string $baseUrl): string
	{
		if ($baseUrl) {
			$baseUrl = rtrim($baseUrl, self::URL_PATH_SEPARATOR);
		}
		return join(self::URL_PATH_SEPARATOR, array_filter([$baseUrl, $urlFragment]));
	}
//	/**
//	 * @var string[]
//	 */
//	private $routes;

//	/**
//	 * @param string $routeName
//	 * @return string
//	 */
//	function getModuleRoute(string $routeName): string
//	{
//		$routes = $this->routes;
//		if (!isset($routes[$routeName])) {
//			throw new \InvalidArgumentException(sprintf("There is no url fragment for url %s!", $routeName));
//
//
//		}
//		return $routes[$routeName];
//	}
}