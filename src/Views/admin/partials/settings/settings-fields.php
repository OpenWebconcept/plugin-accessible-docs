<?php
/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

$api_base_url      = $api_base_url ?? '';
$settings_field_id = $settings_field_id ?? '';

?>

<?php if ( 'owcad_api_base_url' === $settings_field_id ) : ?>
<input type="text" name="owcad_options[owcad_api_base_url]" value="<?php echo esc_attr( $api_base_url ); ?>">
<?php endif; ?>
