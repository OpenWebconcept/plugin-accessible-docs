<?php

namespace OWCAD\Singletons;

/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 0.0.1
 */
class SiteOptionsSingleton
{
	private static $instance = null;
	private array $options;

	private function __construct( array $options )
	{
		$this->options = $options;
	}

	/**
	 * @since 0.0.1
	 */
	private function __clone()
	{
	}

	/**
	 * @since 0.0.1
	 */
	public function __wakeup()
	{
	}

	/**
	 * @since 0.0.1
	 */
	public static function get_instance( array $options ): self
	{
		if ( null == self::$instance ) {
			self::$instance = new SiteOptionsSingleton( $options );
		}

		return self::$instance;
	}

	/**
	 * @since 0.0.1
	 */
	public function api_base_url(): string
	{
		return $this->options['owcad_api_base_url'] ?? '';
	}
}
