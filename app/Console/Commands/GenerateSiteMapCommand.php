<?php
declare( strict_types = 1 );

namespace App\Console\Commands;

use App\Services\SiteMap\SiteMapService;
use Illuminate\Console\Command;

/**
 * Class GenerateSiteMapCommand
 * @package App\Console\Commands
 */
class GenerateSiteMapCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'generate:sitemap {host?}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate sitemap for sites';

	/**
	 * @var SiteMapService
	 */
	protected $siteMapService;

	/**
	 * GenerateSiteMapCommand constructor.
	 * @param SiteMapService $siteMapService
	 */
	public function __construct (SiteMapService $siteMapService)
	{
		$this->siteMapService = $siteMapService;

		parent::__construct();
	}

	/**
	 * Execute the console command.
	 */
	public function handle () : void
	{
		$host = $this->argument('host');

		if ($host)
			$hosts[] = $host;
		else
			$hosts = config('site.host_names');

		foreach ($hosts as $site)
			$this->siteMapService->generate($site);

		$this->info('Generate complete');
	}
}
