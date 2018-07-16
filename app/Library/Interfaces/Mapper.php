<?php
declare( strict_types = 1 );

namespace App\Library\Interfaces;

/**
 * Class Mapper
 * @package App\Library\Interfaces
 */
interface Mapper
{
	/**
	 * @param array $data
	 * @return Item
	 */
	public function map (array $data) : Item;
}