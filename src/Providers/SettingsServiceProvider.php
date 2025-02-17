<?php

namespace OWCAD\Providers;

use OWCAD\Contracts\ServiceProviderInterface;
use OWCAD\Controllers\SettingsController;

class SettingsServiceProvider implements ServiceProviderInterface
{
	private SettingsController $controller;

	public function __construct()
	{
		$this->controller = new SettingsController();
	}

	/**
	 * @since 0.0.1
	 */
	public function register(): void
	{
		add_action( 'admin_menu', array( $this, 'register_settings_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings_options' ) );
	}

	/**
	 * Add a settings page to the wp-admin.
	 *
	 * @since 0.0.1
	 */
	public function register_settings_page(): void
	{
		add_options_page(
			__( 'OWC Toegankelijke documenten', 'owcad-accessible-docs' ),
			__( 'OWC Toegankelijke documenten', 'owcad-accessible-docs' ),
			apply_filters( 'owcad::options_page_capability', 'manage_options' ),
			'owcad-accessible-docs',
			array( $this->controller, 'render_page' )
		);
	}

	/**
	 * Initialize the options for the settings page.
	 *
	 * @since 0.0.1
	 */
	public function register_settings_options(): void
	{
		register_setting(
			'owcad_options_group',
			OWCAD_SITE_OPTION_NAME,
			array(
				'sanitize_callback' => array( $this->controller, 'sanitize_plugin_options_settings' ),
			)
		);

		add_settings_section(
			'owcad_section_general',
			__( 'Instellingen', 'owcad-accessible-docs' ),
			array( $this->controller, 'section_description_general' ),
			'owcad-accessible-docs'
		);

		add_settings_field(
			'owcad_api_base_url',
			__( 'API basis URL', 'owcad-accessible-docs' ),
			array( $this->controller, 'section_fields_render' ),
			'owcad-accessible-docs',
			'owcad_section_general',
			array( 'settings_field_id' => 'owcad_api_base_url' )
		);
	}
}
