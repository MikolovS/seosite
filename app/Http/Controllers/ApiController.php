<?php
declare( strict_types = 1 );

namespace App\Http\Controllers;
use App\Library\Traits\ApiResponseTrait;
use App\Services\SiteMap\SiteMapService;
use seo_db\Models\Post;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiController
 * @package App\Http\Controllers
 */
class ApiController extends Controller
{
	use ApiResponseTrait;

	/**
	 * @var SiteMapService
	 */
	protected $siteMapService;

	/**
	 * ApiController constructor.
	 * @param SiteMapService $siteMapService
	 */
	public function __construct (SiteMapService $siteMapService)
	{
		$this->siteMapService = $siteMapService;
	}

	/**
	 * @param Post $post
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function addPostToSiteMap(Post $post) : Response
	{
		$this->siteMapService->addTagByPost($post);

		return $this->sendResponse();
	}
}