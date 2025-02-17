<?php

namespace OWCAD\Controllers;

/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @since 0.0.1
 */
class SettingsController
{
	/**
	 * @since 0.0.1
	 */
	public function render_page(): void
	{
		owcad_render_view( 'admin/settings-page' );
	}

	/**
	 * @since 0.0.1
	 */
	public function section_description_general(): void
	{
		owcad_render_view( 'admin/partials/settings/settings-description-general' );
	}

	/**
	 * @since 0.0.1
	 */
	public function section_description_rest_api(): void
	{
		owcad_render_view( 'admin/partials/settings/settings-description-rest-api' );
	}

	/**
	 * @since 0.0.1
	 */
	public function section_fields_render( array $args ): void
	{
		owcad_render_view(
			'admin/partials/settings/settings-fields',
			array(
				'api_base_url'      => owcad_resolve_from_container( 'owcad.site_options' )->api_base_url(),
				'settings_field_id' => $args['settings_field_id'] ?? '',
			)
		);
	}

	/**
	 * @since 0.0.1
	 */
	public function sanitize_plugin_options_settings( $settings ): array
	{
		if ( ! is_array( $settings ) ) {
			return array();
		}

		$sanitize_recursive = function ( $value ) use ( &$sanitize_recursive ) {
			if ( is_array( $value ) ) {
				return array_map( $sanitize_recursive, $value );
			}

			if ( is_string( $value ) ) {
				return sanitize_text_field( $value );
			}

			return $value;
		};

		return array_map( $sanitize_recursive, $settings );
	}
}
