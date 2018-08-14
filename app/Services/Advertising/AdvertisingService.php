<?php
declare( strict_types = 1 );

namespace App\Services\Advertising;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;

/**
 * Class FrontBlocks
 * @package App\Models\Services
 */
class AdvertisingService
{
	/** время кеширование ответа */
	public const CACHE_TIME = 10;

	/**
	 * Получает рекламные блоки
	 *
	 * @return mixed
	 */
	public static function get ()
	{
		$result = self::getAdvertisings();

		return collect($result);
	}

	/**
	 * Стандартный ответ в случаи ошибки
	 *
	 * @return Collection
	 */
	private static function defaultResult () : Collection
	{
		return collect([]);
	}

	/**
	 * Получение блоков кода из dalscms DB
	 *
	 * @return mixed
	 */
	private static function getAdvertisings ()
	{
		$dbName = \DB::getDatabaseName();

		try {
			# кешируем результат для уменьшения времени ответа
			$result = Cache::remember('advertisings_' . $dbName, self::CACHE_TIME, function () use ($dbName) {
				# получаем все блоки с кодом сортированые по типам в зависимости от названия подключения к базе данных
				$advertisings = DB::connection('dalscms')->select('
				WITH advertising_block AS(
					SELECT
					  *
					FROM advertisings
					WHERE
					    site_id = (SELECT site_id FROM db_connections WHERE database = :db_name LIMIT 1)  -- код только для этого сайта
					ORDER BY id ASC    
				)
				SELECT
				-- данные получем в виде отсортированых json строк
				  array_to_json(ARRAY(SELECT ad_body_mob FROM advertising_block ORDER BY id ASC)) AS mob,
				                          
				  array_to_json(ARRAY(SELECT ad_body_desktop FROM advertising_block ORDER BY id ASC)) AS desc
				  LIMIT 1
			',
					[
						'db_name' => $dbName,
					]);

				# если данных нет - возвращаем стандартный ответ
				if (empty($advertisings))
					return self::defaultResult();

				# берём первый результат
				$advertisings = array_shift($advertisings);

				# склеиваем елементы каждого массива в строку
				return collect($advertisings)->map(function ($advertising) {
					return json_decode($advertising);
				});
			});
		} catch (\Exception $exception) {

			# в случае непредвиденной ошибки - логируем её и возвращаем стандартный ответ
			Log::error($exception->getMessage(), [
				'file' => $exception->getFile(),
				'line' => $exception->getLine(),
			]);

			Cache::put('advertisings', self::defaultResult(), self::CACHE_TIME);

			$result = self::defaultResult();
		}

		return $result;
	}

	/**
	 * @param string $content
	 * @param bool   $isAMP
	 * @return string
	 */
	public static function prepareContentWithAdvertising (string $content, bool $isAMP = false) : string
	{
		preg_match_all('#\[Adv\sBlock\sid=([\d]+)\]#i', $content, $matches);

		// берем все id блоков
		$replaceableAdvertising = collect($matches[ 1 ]);
		$platform               = self::getVersion();

		/** @var Collection $newAdvertising */
		$newAdvertising = collect(self::get()->get($platform));

		if ($isAMP)
			$newAdvertising = self::makeAMPAdvertising($newAdvertising);

		// перебираем блоки которые необходимо заменить
		$replaceableAdvertising->each(function ($advertising) use ($newAdvertising, &$content) {

			/** @var AdvertisingService $necessaryAdvertising */
			$necessaryAdvertising = $newAdvertising->shift();
			if ($necessaryAdvertising === null)  // если нашли
				$necessaryAdvertising = '';

			$content = str_replace( // то заменяем старый
				"[Adv Block id={$advertising}]",
				$necessaryAdvertising,
				$content
			);

		});

		return $content;
	}

	/**
	 * @return string
	 */
	public static function getVersion () : string
	{
		$agent      = new Agent();
		$is_desktop = $agent->isDesktop();

		return $is_desktop ? 'desc' : 'mob';
	}

	/**
	 * @return mixed|string
	 */
	public static function getLastAdvertising ()
	{
		/** @var Collection $advertisings */
		$advertisings = self::get();

		if ($advertisings->isEmpty())
			return '';

		$advertisings = $advertisings->get(self::getVersion());

		if (null === $advertisings)
			return '';

		return collect($advertisings)->reverse()->first();
	}

	/**
	 * @param Collection $advertising
	 * @return Collection
	 */
	public static function makeAMPAdvertising (Collection $advertising) : Collection
	{
		$awdPattern = '/data-ad-client="(?P<clientId>.+)"(?:[\w\s-_\n\t\r="\'\[\]]+)?data-ad-slot="(?P<slotId>.+)"/i';
		$ampPattern = '
			<amp-ad
			  width="100vw"
			  height="320"
			  type="adsense"
			  data-ad-client="clientId"
			  data-ad-slot="slotId"
			  data-auto-format="rspv"
			  data-full-width>
		    	<div overflow></div>
			</amp-ad>
		';

		return $advertising->map(function ($add) use ($awdPattern, $ampPattern) {
			preg_match($awdPattern, $add, $matches);

			if ( ! isset($matches[ 'clientId' ], $matches[ 'slotId' ]) || ! $matches)
				return $add;

			$ampAdd = str_ireplace('clientId', $matches[ 'clientId' ], $ampPattern);

			return str_ireplace('slotId', $matches[ 'slotId' ], $ampAdd);
		});
	}
}