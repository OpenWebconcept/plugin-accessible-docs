<?php

namespace OWCAD\Traits;

/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 0.0.1
 */
trait ErrorLog
{
	/**
	 * @since 0.0.1
	 */
	public function log_error( string $message ): void
	{
		if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
			return;
		}

		error_log( sprintf( 'OWCAD: %s', $message ) );
	}
}
