<?php
declare( strict_types = 1 );

namespace App\Services\BreadCrumbs\lib\Items;

use App\Library\Interfaces\Item;

/**
 * Class BreadCrumbLeafItem
 * @package App\Services\BreadCrumbs\lib\Items
 */
class BreadCrumbLeafItem implements Item
{
	/**
	 * @var string
	 */
	protected $url;
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @return string
	 */
	public function getUrl () : string
	{
		return $this->url;
	}

	/**
	 * @param string $slug
	 */
	public function setUrl (string $slug) : void
	{
		$this->url = url($slug);
	}

	/**
	 * @return string
	 */
	public function getName () : string
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName ($name) : void
	{
		$this->name = $name;
	}

	/**
	 * @return array
	 */
	public function toArray () : array
	{
		return [
			'name' => $this->getName(),
			'url'  => $this->getUrl(),
		];
	}
}