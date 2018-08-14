<?php
declare( strict_types = 1 );

/**
 * @param string $domain
 * @return string
 */
function convertDomain (string $domain) : string
{
	return str_replace('.', '_', $domain);
}

/**
 * @return string
 */
function getServeLink ()
{
	return ( isset($_SERVER[ 'HTTPS' ]) && $_SERVER[ 'HTTPS' ] === 'on' ? 'https' : 'http' ) .
	               "://$_SERVER[HTTP_HOST]";
}