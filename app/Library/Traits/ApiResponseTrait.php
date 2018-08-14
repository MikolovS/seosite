<?php
declare( strict_types = 1 );

namespace App\Library\Traits;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiResponseTrait
 * @package App\Library\Traits
 */
trait ApiResponseTrait
{
	/**
	 * @param $data
	 * @param string|null $message
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function sendResponse ($data = null, string $message = null) : Response
	{
		return response([
			'success' => true,
			'message' => $message ?? 'Action success',
			'data'    => makeArray($data),
		]);
	}

	/**
	 * @param $data
	 * @param string|null $message
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function sendBadResponse ($data, string $message = null) : Response
	{
		return response([
			'success' => false,
			'message' => $message ?? 'Action failed',
			'data'    => makeArray($data),
		]);
	}
}