<?php

/**
 * @link https://www.openwebconcept.nl
 *
 * @package OWC_Accessible_Docs_Plugin
 *
 * @author  Yard | Digital Agency
 *
 * Plugin Name: OWC Accessible Docs
 * Description: Converts uploaded documents (PDF, Word) into fully accessible HTML pages using NLDoc. Automatically processes files upon upload and generates an accessibility-compliant page within WordPress.
 * Version: 0.0.1
 * Author: Yard | Digital Agency
 * Author URI: https://www.yard.nl
 * License: GPLv2 or later
 * Text Domain: owc-accessible-docs
 * Domain Path: /languages
 * Requires at least: 6.0
 */

/**
 * If this file is called directly, abort.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'OWCAD_VERSION', '0.0.1' );
define( 'OWCAD_REQUIRED_WP_VERSION', '6.0' );
define( 'OWCAD_PLUGIN_NAME', basename( __DIR__ ) );
define( 'OWCAD_PLUGIN_FILE', __FILE__ );
define( 'OWCAD_PLUGIN_URL', plugins_url( '/', OWCAD_PLUGIN_NAME ) );
define( 'OWCAD_PLUGIN_DIR_PATH', plugin_dir_path( OWCAD_PLUGIN_FILE ) );
define( 'OWCAD_SITE_OPTION_NAME', 'owcad_options' );

/**
 * Require autoloader.
 */
if ( file_exists( __DIR__ . '/vendor-prefixed/autoload.php' ) ) {
	require_once __DIR__ . '/vendor-prefixed/autoload.php';
}
require_once __DIR__ . '/src/autoloader.php';
require_once __DIR__ . '/src/Bootstrap.php';

add_action(
	'plugins_loaded',
	function () {
		$init = new OWCAD\Bootstrap();
	}
);
