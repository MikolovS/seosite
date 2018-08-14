<?php
declare( strict_types = 1 );

namespace App\Http\Controllers;

use App\Services\BreadCrumbs\BreadCrumbsService;
use App\Services\Content\ContentService;
use App\Services\HeadGenerator\HeadGeneratorService;
use Illuminate\View\View;
use seo_db\Models\Author;
use seo_db\Models\Category;
use seo_db\Models\Post;
use seo_db\Models\Tag;

/**
 * Class SiteController
 * @package App\Http\Controllers
 */
class SiteController extends Controller
{
	/**
	 * @var ContentService
	 */
	protected $contentService;

	/**
	 * @var BreadCrumbsService
	 */
	protected $breadCrumbsService;

	/**
	 * @var HeadGeneratorService
	 */
	protected $headService;

	/**
	 * SiteController constructor.
	 * @param ContentService       $contentService
	 * @param BreadCrumbsService   $breadCrumbsService
	 * @param HeadGeneratorService $headGeneratorService
	 */
	public function __construct (
		ContentService $contentService,
		BreadCrumbsService $breadCrumbsService,
		HeadGeneratorService $headGeneratorService)
	{
		$this->contentService     = $contentService;
		$this->breadCrumbsService = $breadCrumbsService;
		$this->headService        = $headGeneratorService;
	}

	/**
	 * @return View
	 */
	public function index () : View
	{
		return view('main.content')->with([
			'categories'        => $this->contentService->getMainPageContent(),
			'sliderContent'     => $this->contentService->getSliderContent(),
			'newsSliderContent' => $this->contentService->getNewsSliderContent(),
			'metas'             => [
				$this->headService->getSiteOgType(),
			],
		]);
	}

	/**
	 * @param Category $category
	 * @param Post     $post
	 * @return View
	 */
	public function showPostPage (Category $category, Post $post) : View
	{
		return view('post.page')->with([
			'post'        => $this->contentService->getPostContent($post),
			'breadCrumbs' => $this->breadCrumbsService->getForPost($post),
			'nextPost'    => $this->contentService->getNextPost($category, $post),
			'metas'       => [
				$this->headService->getArticleOgType(),
				$this->headService->getArticleOgModifiedTime($post->updated_at->toDateTimeString()),
				$this->headService->getArticleOgPublishTime($post->created_at->toDateTimeString()),
				$post->meta,
			],
		]);
	}

	/**
	 * @param Category $category
	 * @param Post     $post
	 * @return View
	 */
	public function showAmpPostPage (Category $category, Post $post) : View
	{
		return view('post.page')->with([
			'post'        => $this->contentService->getAmpContent($post),
			'breadCrumbs' => $this->breadCrumbsService->getForPost($post),
			'nextPost'    => $this->contentService->getNextPost($category, $post),
			'metas'       => [
				$this->headService->getArticleOgType(),
				$this->headService->getArticleOgModifiedTime($post->updated_at->toDateTimeString()),
				$this->headService->getArticleOgPublishTime($post->created_at->toDateTimeString()),
				$post->meta,
			],
		]);
	}

	/**
	 * @param Category $category
	 * @return View
	 */
	public function showCategoryPage (Category $category) : View
	{
		return view('category.container')->with([
			'posts'        => $this->contentService->getPosts($category),
			'breadCrumbs'  => $this->breadCrumbsService->getForCategory($category),
			'categoryTags' => $this->contentService->getCategoryTags($category),
			'metas'        => [
				$this->headService->getSiteOgType(),
				$category->meta,
			],
		]);
	}

	/**
	 * @param Tag $tag
	 * @return View
	 */
	public function showTagPage (Tag $tag) : View
	{
		$posts = $this->contentService->getPosts($tag);

		return view('post.container')->with([
			'posts' => $posts,
			'metas' => [
				$this->headService->getSiteOgType(),
				$this->headService->getNoIndexFollow($posts),
				$tag->meta,
			],
		]);
	}

	/**
	 * @param Category $category
	 * @param Tag      $tag
	 * @return View
	 */
	public function showCategoryTagsPage (Category $category, Tag $tag) : View
	{
		$posts = $this->contentService->getPostsByCategoryAndTag($category, $tag);

		return view('post.container')->with([
			'posts'        => $posts,
			'categoryTags' => $this->contentService->getCategoryTags($category),
			'metas'        => [
				$this->headService->getSiteOgType(),
				$this->headService->getNoIndexFollow($posts),
				$tag->meta,
				$category->meta,
			],
		]);
	}

	/**
	 * @param Author $author
	 * @return View
	 */
	public function showAuthorPostsPage (Author $author) : View
	{
		return view('author.page')->with([
			'author'      => $author,
			'posts'       => $this->contentService->getPosts($author),
			'breadCrumbs' => $this->breadCrumbsService->getForAuthor($author),
			'metas'       => [
				$this->headService->getSiteOgType(),
				$author->meta,
			],
		]);
	}

	/**
	 * @return View
	 */
	public function showAuthorsPage () : View
	{
		return view('author.container')->with([
			'authors'     => $this->contentService->getAuthorsPageContent(),
			'breadCrumbs' => $this->breadCrumbsService->getForAuthorsPage(),
			'metas'       => [
				$this->headService->getSiteOgType(),
			],
		]);
	}
}
