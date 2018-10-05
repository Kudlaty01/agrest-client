<?php

namespace Qdt01\AgRest\Middleware;

use Psr\Http\Message\UriInterface;
use Qdt01\AgRest\Middleware\Filters\Uri\{FragmentFilterInterface,
	PathFilterInterface,
	QueryFilterInterface,
	SchemeFilterInterface,
	UserInfoFilterInterface};
use Qdt01\AgRest\Middleware\Validators\Uri\{HostValidatorInterface,
	PathValidatorInterface,
	PortValidatorInterface,
	QueryValidatorInterface,
	SchemeValidator,
	UriPartsValidatorInterface,
	UserInfo\PasswordValidatorInterface,
	UserInfo\UserValidatorInterface};

/**
 * Class Uri
 *
 * @package \Qdt01\AgRest\Middleware
 */
class Uri implements UriInterface
{
	//region Constants
	const CHAR_SUB_DELIMS = '!\$&\'\(\)\*\+,;=';
	const CHAR_UNRESERVED = 'a-zA-Z0-9_\-\.~\pL';
	//endregion

	//region Fields
	/** @var string */
	protected $host;
	/** @var string */
	protected $scheme;
	/** @var int */
	protected $port;
	/** @var string */
	protected $path;
	/** @var string */
	protected $userInfo;
	/** @var string */
	protected $cachedString;
	/** @var string */
	protected $query;
	//region Validators
	/** @var SchemeValidator */
	protected $schemeValidator;
	/** @var UserValidatorInterface */
	protected $userIntoUserValidator;
	/** @var PasswordValidatorInterface */
	protected $userIntoPasswordValidator;
	/** @var UserInfoFilterInterface */
	protected $userInfoFilter;
	/** @var HostValidatorInterface */
	protected $hostValidator;
	/** @var PathValidatorInterface */
	protected $pathValidator;
	/** @var QueryValidatorInterface */
	protected $queryValidator;
	/** @var UriPartsValidatorInterface */
	protected $uriPartsValidator;
	/** @var PortValidatorInterface */
	protected $portValidator;
	//endregion
	//region Filters
	/** @var QueryFilterInterface */
	protected $queryFilter;
	/** @var FragmentFilterInterface */
	protected $fragmentFilter;
	/** @var string */
	protected $fragment;
	/** @var PathFilterInterface */
	protected $pathFilter;
	/** @var SchemeFilterInterface */
	protected $schemeFilter;
	//endregion

	/**
	 * Uri constructor.
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
	 * @param SchemeFilterInterface      $schemeFilter
	 * @param UriPartsValidatorInterface $uriPartsValidator
	 * @param PortValidatorInterface     $portValidator
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
		SchemeFilterInterface $schemeFilter,
		UriPartsValidatorInterface $uriPartsValidator,
		PortValidatorInterface $portValidator
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
		$this->schemeFilter              = $schemeFilter;
		$this->portValidator             = $portValidator;
	}
	//endregion


	//region Methods
	public function getScheme(): string
	{
		return $this->scheme;
	}

	public function getUserInfo(): string
	{
		return $this->userInfo;
	}

	public function getHost(): string
	{
		return $this->host;
	}

	public function getPort(): ?int
	{
		return $this->port;
	}

	public function getPath(): string
	{
		return $this->path;
	}

	public function getQuery(): string
	{
		return $this->query;
	}

	public function getFragment(): string
	{
		return $this->fragment;
	}

	public function withScheme($scheme): UriInterface
	{
		$this->schemeValidator->validate($scheme);

		$scheme = $this->schemeFilter->filter($scheme);

		if ($scheme === $this->scheme) {
			return $this;
		}

		$clone         = clone $this;
		$clone->scheme = $scheme;

		return $clone;
	}

	public function withUserInfo($user, $password = null): UriInterface
	{
		$this->userIntoUserValidator->validate($user);
		$this->userIntoPasswordValidator->validate($password);

		$info = $this->userInfoFilter->filter($user);
		if (null !== $password) {
			$info .= ':' . $this->userInfoFilter->filter($password);
		}

		if ($info === $this->userInfo) {
			return $this;
		}

		$clone           = clone $this;
		$clone->userInfo = $info;

		return $clone;
	}

	public function withHost($host)
	{
		$this->hostValidator->validate($host);

		if ($host === $this->host) {
			return $this;
		}

		$clone       = clone $this;
		$clone->host = strtolower($host);

		return $clone;
	}

	public function withPort($port)
	{
		$this->portValidator->validate($port);
		if ($port !== null) {
			$port = intval($port);
		}

		if ($port === $this->port) {
			return $this;
		}

		$clone       = clone $this;
		$clone->port = $port;

		return $clone;
	}

	public function withPath($path)
	{
		$this->pathValidator->validate($path);

		$path = $this->pathFilter->filter($path);

		if ($path === $this->path) {
			return $this;
		}

		$clone       = clone $this;
		$clone->path = $path;

		return $clone;
	}

	public function withQuery($query)
	{
		$this->queryValidator->validate($query);

		$query = $this->queryFilter->filter($query);

		if ($query === $this->query) {
			return $this;
		}

		$clone        = clone $this;
		$clone->query = $query;

		return $clone;
	}

	public function withFragment($fragment)
	{
		$fragment = $this->fragmentFilter->filter($fragment);

		if ($fragment === $this->fragment) {
			return $this;
		}

		$clone           = clone $this;
		$clone->fragment = $fragment;

		return $clone;
	}

	public function __toString()
	{
		if (isset($this->cachedString)) {
			return $this->cachedString;
		}
		$this->cachedString = self::buildUri(
			$this->scheme,
			$this->getAuthority(),
			$this->path,
			$this->query,
			$this->fragment
		);
		return $this->cachedString;
	}

	private static function buildUri($scheme, $authority, $path, $query, $fragment): string
	{

		$uri = '';

		if (!empty($scheme)) {
			$uri .= "$scheme:";
		}

		if (!empty($authority)) {
			$uri .= "//$authority";
		}

		if (!empty($path) && 0 !== strpos($path, '/')) {
			$path = "/$path";
		}

		$uri .= $path;

		if (!empty($query)) {
			$uri .= "?$query";
		}

		if (!empty($fragment)) {
			$uri .= "#$fragment";
		}

		return $uri;
	}

	public function getAuthority(): string
	{
		//be noted that according to Mozilla use of this URL is deprecated
		$authority = join('@', array_filter([$this->userInfo, $this->host]));
		$authority = join(':', array_filter([$authority, $this->port]));

		return $authority;
	}

	public function parseString(string $uri): UriInterface
	{

		$parts = parse_url($uri);

		$this->uriPartsValidator->validate($parts);

		$this->scheme   = $parts['scheme'] ?? '';
		$this->userInfo = $parts['user'] ?? '';
		$this->host     = isset($parts['host']) ? strtolower($parts['host']) : '';
		$this->port     = $parts['port'] ?? null;
		$this->path     = $parts['path'] ?? '';
		$this->query    = $parts['query'] ?? '';
		$this->fragment = $parts['fragment'] ?? '';

		if (isset($parts['pass'])) {
			$this->userInfo .= ':' . $parts['pass'];
		}
		return $this;
	}

	//endregion
}