<?php
declare( strict_types = 1 );

namespace App\Services\NavBar;

use App\Repositories\CategoryRepository;
use App\Services\CacheService\CacheService;

/**
 * Class NavBarService
 * @package App\Services
 */
class NavBarService
{
	/**
	 * @var CacheService
	 */
	private $cacheManager;

	/**
	 * @var CategoryRepository
	 */
	private $categoryRep;

	/**
	 * NavBarService constructor.
	 * @param CacheService       $cacheService
	 * @param CategoryRepository $categoryRepository
	 */
	public function __construct (CacheService $cacheService, CategoryRepository $categoryRepository)
	{
		$this->cacheManager = $cacheService;
		$this->categoryRep  = $categoryRepository;
	}

	/**
	 * @return self
	 */
	public static function make () : self
	{
		return \App::make(self::class);
	}

	/**
	 * @return mixed
	 */
	public function getCategoryTree ()
	{
		return $this->cacheManager->get('navbar_cats', function () {
			return $this->categoryRep->getCategoriesForNavBar();
		});
	}
}