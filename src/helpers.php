<?php

/**
 * Plugin helpers.
 *
 * @package OWC_Accessible_Docs_Plugin
 *
 * @author  Yard | Digital Agency
 *
 * @since   0.0.1
 */

/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render a view file.
 *
 * @package OWC_Accessible_Docs_Plugin
 *
 * @author  Yard | Digital Agency
 *
 * @since   0.0.1
 */
function owcad_render_view( string $file_path, $data = array() )
{
	$full_path = OWCAD_PLUGIN_DIR_PATH . 'src/Views/' . $file_path . '.php';

	if ( ! file_exists( $full_path ) ) {
		return '';
	}
	extract( $data, EXTR_SKIP );

	return require $full_path;
}

/**
 * Finds an entry of the container by its identifier and returns it.
 *
 * @package OWC_Accessible_Docs_Plugin
 *
 * @author  Yard | Digital Agency
 *
 * @since   0.0.1
 */
function owcad_resolve_from_container( string $container )
{
	return OWCAD\Bootstrap::get_container()->get( $container );
}
