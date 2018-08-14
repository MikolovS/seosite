<?php
declare( strict_types = 1 );

namespace Tests\Unit\Services\SiteMap;

use App;
use App\Services\SiteMap\SiteMapService;
use File;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class SiteMapServiceTest
 * @package Tests\Unit\Services\SiteMap
 */
class SiteMapServiceTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * @var SiteMapService
	 */
	private static $siteMapService;

	/**
	 * @var string
	 */
	private static $siteLink;

	/**
	 *
	 */
	public function setUp () : void
	{
		parent::setUp();

		self::$siteMapService = App::make(SiteMapService::class);
		self::$siteLink = collect(config('site.host_names'))->first();
	}

	/**
	 * @group SiteMapService
	 */
	public function testGenerate () : void
	{
		$hostName = parse_url(self::$siteLink)[ 'host' ];

		$configHostName = convertDomain($hostName);

		$siteMapDir = self::$siteMapService->generate(self::$siteLink, 1);

		$this->assertTrue(File::exists($siteMapDir));
		$this->assertTrue((bool) preg_match('/' . $configHostName . '/i', $siteMapDir));
		$this->assertTrue(File::exists($siteMapDir . '/' . self::$siteMapService::SITE_MAP_FILE_NAME));
	}

	/**
	 *
	 */
	public function tearDown () : void
	{
		$directories =  File::directories(self::$siteMapService->getSiteMapFolder());

		foreach ($directories as $directory)
			File::deleteDirectory($directory);

		parent::tearDown();
	}
}