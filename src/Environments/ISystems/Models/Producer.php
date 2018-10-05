<?php

namespace Qdt01\AgRest\Modules\ISystems\Models;

/**
 * Class Producer
 *
 * @package \Qdt01\AgRest\Models
 */
class Producer implements ModelInterface
{
	//region Fields
	/**
	 * @var integer
	 */
	protected $id;
	/**
	 * @var string
	 */
	protected $name;
	/**
	 * @var string
	 */
	protected $site_url;
	/**
	 * @var string
	 */
	protected $logo_filename;
	/**
	 * @var integer
	 */
	protected $ordering;
	/**
	 * @var string
	 */
	protected $source_id;
	//endregion

	//region Methods
	//region Getters and setters
	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return Producer
	 */
	public function setId(int $id): Producer
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return Producer
	 */
	public function setName(string $name): Producer
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSiteUrl(): string
	{
		return $this->site_url;
	}

	/**
	 * @param string $site_url
	 * @return Producer
	 */
	public function setSiteUrl(string $site_url): Producer
	{
		$this->site_url = $site_url;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getLogoFilename(): string
	{
		return $this->logo_filename;
	}

	/**
	 * @param string $logo_filename
	 * @return Producer
	 */
	public function setLogoFilename(string $logo_filename): Producer
	{
		$this->logo_filename = $logo_filename;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getOrdering(): int
	{
		return $this->ordering;
	}

	/**
	 * @param int $ordering
	 * @return Producer
	 */
	public function setOrdering(int $ordering): Producer
	{
		$this->ordering = $ordering;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSourceId(): string
	{
		return $this->source_id;
	}

	/**
	 * @param string $source_id
	 * @return Producer
	 */
	public function setSourceId(string $source_id): Producer
	{
		$this->source_id = $source_id;
		return $this;
	}

	//endregion
	//endregion
}