<?php
/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
?>
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<form action="<?php echo esc_url( 'options.php' ); ?>" method="post">
		<?php
		settings_fields( 'owcad_options_group' );
		do_settings_sections( 'owcad-accessible-docs' );
		submit_button( __( 'Opslaan', 'owcad-accessible-docs' ) );
		?>
	</form>
</div>
