<?php
declare( strict_types = 1 );

namespace App\Services\SiteMap;

use Illuminate\Filesystem\Filesystem;
use seo_db\Models\Post;
use Spatie\Sitemap\SitemapGenerator;

/**
 * Class SiteMapService
 * @package App\Services\SiteMap
 */
class SiteMapService
{
	public const SITE_MAP_FILE_NAME = 'sitemap.xml';
	public const TAGS_PER_SITE_MAP  = 40000;
	public const SITE_MAP_FOLDER    = 'sitemaps/';

	/**
	 * @var SitemapGenerator
	 */
	private $generator;

	/**
	 * @var Filesystem
	 */
	private $filesystem;

	/**
	 * SiteMapService constructor.
	 * @param SitemapGenerator $siteMapGenerator
	 * @param Filesystem       $filesystem
	 */
	public function __construct (SitemapGenerator $siteMapGenerator, Filesystem $filesystem)
	{
		$this->generator  = $siteMapGenerator;
		$this->filesystem = $filesystem;
	}

	/**
	 * @param string   $host
	 * @param int|null $crawlerCount
	 * @return string
	 */
	public function generate (string $host, int $crawlerCount = null) : string
	{
		$hostSiteMapDir = $this->getSiteMapHostFolder($host);

		if ( ! $this->filesystem->exists($hostSiteMapDir))
			$this->filesystem->makeDirectory($hostSiteMapDir);

		$generator = $this->generator::create($host)
		                             ->maxTagsPerSitemap(self::TAGS_PER_SITE_MAP);
		if ($crawlerCount)
			$generator->setMaximumCrawlCount($crawlerCount);

		$generator->writeToFile($hostSiteMapDir . '/' . self::SITE_MAP_FILE_NAME);

		return $hostSiteMapDir;
	}

	/**
	 * @param Post $post
	 * @return bool
	 */
	public function addTagByPost (Post $post) : bool
	{
		$postUrl = url($post->mainCategory->slug . '/' . $post->slug);

		$siteMap = $this->generator::create($postUrl);
		$siteMap->setMaximumCrawlCount(1);

		$tag = $siteMap->getSitemap()
		               ->getTags()[ 0 ];

		$view = view('laravel-sitemap::url')->withTag($tag)->render();

		$files = $this->filesystem->files(public_path(self::SITE_MAP_FOLDER . convertDomain(\Request::getHost()) . '/'));

		$lastSiteMapPath = collect($files)->last()->getRealPath();

		$str = str_replace('</urlset>', $view . '</urlset>', file_get_contents($lastSiteMapPath));

		file_put_contents($lastSiteMapPath, $str);

		return true;
	}

	/**
	 * @param string $host
	 * @return string
	 */
	private function getSiteMapHostFolder (string $host) : string
	{
		$hostName = parse_url($host)[ 'host' ];

		$configHostName = convertDomain($hostName);

		return public_path(self::SITE_MAP_FOLDER . $configHostName);
	}

	/**
	 * @return string
	 */
	public function getSiteMapFolder () : string
	{
		return public_path(self::SITE_MAP_FOLDER);
	}
}