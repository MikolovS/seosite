<?php
declare( strict_types = 1 );

namespace App\Services\BreadCrumbs\lib\Mappers;

use App\Library\Interfaces\Item;
use App\Library\Interfaces\Mapper;
use App\Services\BreadCrumbs\lib\Items\BreadCrumbLeafItem;

/**
 * Class BreadCrumbsLeafMapper
 * @package App\Services\BreadCrumbs\lib\Mappers
 */
class BreadCrumbsLeafMapper implements Mapper
{
	/**
	 * @param array $data
	 * @return Item
	 */
	public function map (array $data) : Item
	{
		$item = new BreadCrumbLeafItem();

		$item->setUrl($data[ 'slug' ]);
		$item->setName($data[ 'name' ]);

		return $item;
	}
}