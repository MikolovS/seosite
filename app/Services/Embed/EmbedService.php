<?php
declare( strict_types = 1 );

namespace App\Services\Embed;

use Jenssegers\Agent\Agent;

/**
 * Class EmbedService
 * @package App\Classes\EmbedService
 */
class EmbedService
{
	/**
	 * @param string $content
	 * @return string
	 */
	public static function replace (string $content) : string
	{
		$size    = ( new Agent() )->isDesktop() ? 'large' : 'medium';
		$content = str_replace('[PINTEREST-EMBED-SIZE]', $size, $content);

		return $content;
	}
}