<?php

/**
 * PHP DI.
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

return array(
	'owcad.site_options' => OWCAD\Singletons\SiteOptionsSingleton::get_instance( get_option( OWCAD_SITE_OPTION_NAME, array() ) ?: array() ),
);
