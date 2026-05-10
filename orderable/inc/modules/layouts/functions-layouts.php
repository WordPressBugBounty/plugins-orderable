<?php
/**
 * Functions: Layouts.
 *
 * @package Orderable/Functions
 */

defined( 'ABSPATH' ) || exit;

/**
 * Orderable function to render layout.
 *
 * @param int|null $id
 */
function orderable( $id = null ) {
	echo wp_kses(
		Orderable_Layouts::orderable_shortcode(
			array(
				'id' => $id,
			)
		),
		Orderable_Helpers::kses_allowed_html( 'frontend' )
	);
}
