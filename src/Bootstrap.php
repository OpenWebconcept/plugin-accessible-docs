<?php

namespace OWCAD;

/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use OWCAD\Providers\AttachmentUploadServiceProvider;
use OWCAD\Providers\SettingsServiceProvider;
use OWCAD\Vendor_Prefixed\DI\ContainerBuilder;
use OWCAD\Vendor_Prefixed\Psr\Container\ContainerInterface;

require_once __DIR__ . '/helpers.php';

/**
 * @since 0.0.1
 */
class Bootstrap
{
	/**
	 * @since 0.0.1
	 */
	private static ContainerInterface $container;

	/**
	 * @since 0.0.1
	 */
	private array $providers;

	/**
	 * @since 0.0.1
	 */
	public function __construct()
	{
		add_action(
			'init',
			function () {
				$this->register_plugin_text_domain();
				self::$container = $this->build_container();
				$this->providers = $this->get_providers();
				$this->register_providers();
			}
		);
	}

	/**
	 * @since 0.0.1
	 */
	protected function build_container(): ContainerInterface
	{
		$builder = new ContainerBuilder();
		$builder->addDefinitions( OWCAD_PLUGIN_DIR_PATH . 'config/php-di.php' );
		$container = $builder->build();

		return $container;
	}

	/**
	 * @since 0.0.1
	 */
	protected function get_providers(): array
	{
		return array(
			new AttachmentUploadServiceProvider(),
			new SettingsServiceProvider(),
		);
	}

	/**
	 * @since 0.0.1
	 */
	protected function register_providers(): void
	{
		foreach ( $this->providers as $provider ) {
			$provider->register();
		}
	}

	/**
	 * @since 0.0.1
	 */
	protected function register_plugin_text_domain(): void
	{
		load_plugin_textdomain( OWCAD_PLUGIN_NAME, false, OWCAD_PLUGIN_NAME . '/languages/' );
	}

	/**
	 * @since 0.0.1
	 */
	public static function get_container(): ContainerInterface
	{
		return self::$container;
	}
}
