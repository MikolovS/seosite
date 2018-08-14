<?php
declare( strict_types = 1 );

/**
 * @param $data
 * @return array
 */
function makeArray ($data) : array
{
	if (   $data instanceof \Illuminate\Support\Collection
	       || $data instanceof \Illuminate\Database\Eloquent\Model     )
		return $data->toArray();
	else
		return (array)$data;
}