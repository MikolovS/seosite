<?php
declare( strict_types = 1 );

namespace App\Library\Interfaces;

/**
 * Interface Item
 * @package App\Library\Interfaces
 */
interface Item
{
	/**
	 * @return array
	 */
	public function toArray() : array;
}