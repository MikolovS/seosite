<?php
declare( strict_types = 1 );

namespace App\Services\HeadGenerator;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class HeadGeneratorService
 * @package App\Services\Embed
 */
class HeadGeneratorService
{
	/**
	 * @return string
	 */
	public function getSiteOgType () : string
	{
		return '<meta property="og:type" content="website" />';
	}

	/**
	 * @return string
	 */
	public function getArticleOgType () : string
	{
		return '<meta property="og:type" content="article" />';
	}

	/**
	 * @param $publishTime
	 * @return string
	 */
	public function getArticleOgPublishTime (string $publishTime) : string
	{
		return '<meta property="article:published_time" content="' . $publishTime . '" />';
	}

	/**
	 * @param $modifiedTime
	 * @return string
	 */
	public function getArticleOgModifiedTime (string $modifiedTime) : string
	{
		return '<meta property="article:published_time" content="' . $modifiedTime . '" />';
	}

	/**
	 * @param LengthAwarePaginator $posts
	 * @return string
	 */
	public function getNoIndexFollow (LengthAwarePaginator $posts) : string
	{
		if ($posts->count() < 5)
			$meta = '<meta name="robots" content="noindex, follow" />';

		return $meta ?? '';
	}
}