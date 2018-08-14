<?php
declare( strict_types = 1 );

namespace App\Services\BreadCrumbs\lib\Items;

use App\Library\Interfaces\Item;
use Illuminate\Support\Collection;

/**
 * Class BreadCrumbsItem
 * @package App\Services\BreadCrumbs\lib\Items
 */
class BreadCrumbsItem implements Item
{
	/**
	 * @var Collection
	 */
	protected $paths;

	/**
	 * @return Collection
	 */
	public function getPaths () : Collection
	{
		return $this->paths;
	}

	/**
	 * @param Collection $paths
	 */
	public function setPaths (Collection $paths) : void
	{
		$this->paths = $paths;
	}

	/**
	 * @return BreadCrumbLeafItem
	 */
	public function getCurrentPage () : BreadCrumbLeafItem
	{
		return $this->currentPage;
	}

	/**
	 * @param BreadCrumbLeafItem $currentPage
	 */
	public function setCurrentPage (BreadCrumbLeafItem $currentPage) : void
	{
		$this->currentPage = $currentPage;
	}

	/**
	 * @var BreadCrumbLeafItem
	 */
	protected $currentPage;

	/**
	 * @return array
	 */
	public function toArray () : array
	{
		return [
			'paths'        => $this->getPaths(),
			'current_page' => $this->getCurrentPage(),
		];
	}
}