<?php
/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

// Translators: %s is the URL to the Deepl API documentation page.
$website_url = '<a href="' . esc_url( 'https://www.digitoegankelijk.nl/nieuws/publicatietool-nldoc' ) . '">' . esc_html__( 'website', 'owcad-accessible-docs' ) . '</a>';
?>
<p>
	<?php
	printf(
		// Translators: %s is the link to the Deepl API documentation website.
		esc_html__( 'Meer informatie over de koppeling met NLdoc vind je op hun %s.', 'owcad-accessible-docs' ),
		$website_url,
	);
	?>
</p>
