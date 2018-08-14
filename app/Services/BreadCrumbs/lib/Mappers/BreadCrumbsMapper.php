<?php
declare( strict_types = 1 );

namespace App\Services\BreadCrumbs\lib\Mappers;

use App\Library\Interfaces\Item;
use App\Library\Interfaces\Mapper;
use App\Services\BreadCrumbs\lib\Items\BreadCrumbsItem;

/**
 * Class BreadCrumbsMapper
 * @package App\Services\BreadCrumbs\lib\Mappers
 */
class BreadCrumbsMapper implements Mapper
{
	/**
	 * @param array $data
	 * @return BreadCrumbsItem
	 */
	public function map (array $data) : Item
	{
		$item = new BreadCrumbsItem();

		$item->setPaths($data[ 'paths' ]);
		$item->setCurrentPage($data[ 'current_page' ]);

		return $item;
	}
}