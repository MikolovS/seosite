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