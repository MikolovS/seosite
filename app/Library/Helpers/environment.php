<?php
declare( strict_types = 1 );

/**
 * @return bool
 */
function isLocalEnvironment() : bool
{
	return \App::environment() === 'local';
}