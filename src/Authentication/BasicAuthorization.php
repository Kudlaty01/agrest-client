<?php

namespace Qdt01\AgRest\Authentication;

use Psr\Http\Message\RequestInterface;

/**
 * Class BasicAuthentication
 *
 * @package \Qdt01\AgRest\Authentication
 */
class BasicAuthorization extends AbstractAuthorization
{
	/** @var string */
	private $userName;
	/** @var string */
	private $password;
	/** @var string */
	private $headerToken;

	public function setCredentials(string $userName, string $password): AuthorizationInterface
	{
		$this->userName = $userName;
		$this->password = $password;
		return $this;
	}

	public function authorize(RequestInterface $request): RequestInterface
	{
		if (empty($this->headerToken)) {
			$this->headerToken = base64_encode(join(':', [$this->userName, $this->password]));
		}
		$headerValue = 'Basic ' . $this->headerToken;
		return $request->withAddedHeader('Authorization', $headerValue);
	}
}