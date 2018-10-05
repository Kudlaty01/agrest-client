<?php

namespace Qdt01\AgRest\Middleware\Factories;

use Qdt01\{AgRest\Middleware\Filters\Uri\FragmentFilterInterface,
	AgRest\Middleware\Filters\Uri\PathFilterInterface,
	AgRest\Middleware\Filters\Uri\QueryFilterInterface,
	AgRest\Middleware\Filters\Uri\UserInfoFilterInterface,
	AgRest\Middleware\Uri,
	AgRest\Middleware\Validators\Uri\HostValidatorInterface,
	AgRest\Middleware\Validators\Uri\PathValidatorInterface,
	AgRest\Middleware\Validators\Uri\QueryValidatorInterface,
	AgRest\Middleware\Validators\Uri\SchemeValidator,
	AgRest\Middleware\Validators\Uri\UriPartsValidatorInterface,
	AgRest\Middleware\Validators\Uri\UserInfo\PasswordValidatorInterface,
	AgRest\Middleware\Validators\Uri\UserInfo\UserValidatorInterface};
use Windwalker\Uri\UriInterface;

/**
 * Class UriFactory
 *
 * @package \Qdt01\AgRest\Middleware\Factories
 */
class UriFactory implements UriFactoryInterface
{
	/**
	 * @var SchemeValidator
	 */
	private $schemeValidator;
	/**
	 * @var UserValidatorInterface
	 */
	private $userIntoUserValidator;
	/**
	 * @var PasswordValidatorInterface
	 */
	private $userIntoPasswordValidator;
	/**
	 * @var UserInfoFilterInterface
	 */
	private $userInfoFilter;
	/**
	 * @var HostValidatorInterface
	 */
	private $hostValidator;
	/**
	 * @var PathValidatorInterface
	 */
	private $pathValidator;
	/**
	 * @var QueryValidatorInterface
	 */
	private $queryValidator;
	/**
	 * @var PathFilterInterface
	 */
	private $pathFilter;
	/**
	 * @var QueryFilterInterface
	 */
	private $queryFilter;
	/**
	 * @var FragmentFilterInterface
	 */
	private $fragmentFilter;
	/**
	 * @var UriPartsValidatorInterface
	 */
	private $uriPartsValidator;


	/**
	 * UriFactory constructor.
	 * @param SchemeValidator            $schemeValidator
	 * @param UserValidatorInterface     $userIntoUserValidator
	 * @param PasswordValidatorInterface $userIntoPasswordValidator
	 * @param UserInfoFilterInterface    $userInfoFilter
	 * @param HostValidatorInterface     $hostValidator
	 * @param PathValidatorInterface     $pathValidator
	 * @param QueryValidatorInterface    $queryValidator
	 * @param PathFilterInterface        $pathFilter
	 * @param QueryFilterInterface       $queryFilter
	 * @param FragmentFilterInterface    $fragmentFilter
	 * @param UriPartsValidatorInterface $uriPartsValidator
	 */
	public function __construct(
		SchemeValidator $schemeValidator,
		UserValidatorInterface $userIntoUserValidator,
		PasswordValidatorInterface $userIntoPasswordValidator,
		UserInfoFilterInterface $userInfoFilter,
		HostValidatorInterface $hostValidator,
		PathValidatorInterface $pathValidator,
		QueryValidatorInterface $queryValidator,
		PathFilterInterface $pathFilter,
		QueryFilterInterface $queryFilter,
		FragmentFilterInterface $fragmentFilter,
		UriPartsValidatorInterface $uriPartsValidator
	)
	{
		$this->schemeValidator           = $schemeValidator;
		$this->userIntoUserValidator     = $userIntoUserValidator;
		$this->userIntoPasswordValidator = $userIntoPasswordValidator;
		$this->userInfoFilter            = $userInfoFilter;
		$this->hostValidator             = $hostValidator;
		$this->pathValidator             = $pathValidator;
		$this->queryValidator            = $queryValidator;
		$this->pathFilter                = $pathFilter;
		$this->queryFilter               = $queryFilter;
		$this->fragmentFilter            = $fragmentFilter;
		$this->uriPartsValidator         = $uriPartsValidator;
	}

	function createUri(string $address): UriInterface
	{

		$uri = new Uri(
			$this->schemeValidator,
			$this->userIntoUserValidator,
			$this->userIntoPasswordValidator,
			$this->userInfoFilter,
			$this->hostValidator,
			$this->pathValidator,
			$this->queryValidator,
			$this->pathFilter,
			$this->queryFilter,
			$this->fragmentFilter,
			$this->uriPartsValidator
		);
		return $uri->parseString($address);
	}
}