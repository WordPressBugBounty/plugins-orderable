<?php
/**
 * Drawer: Floating Cart Button.
 *
 * This template can be overridden by copying it to yourtheme/orderable/drawer/floating-cart.php
 *
 * HOWEVER, on occasion Orderable will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @package Orderable/Templates
 */

defined( 'ABSPATH' ) || exit;

$position = Orderable_Settings::get_setting( 'style_cart_position' );

if ( 'none' === $position ) {
	return;
}

$cart_count = WC()->cart->get_cart_contents_count();
$style      = Orderable_Drawer_Settings::get_cart_icon_css();
?>

<div class="orderable-floating-cart orderable-floating-cart--<?php echo esc_attr( $position ); ?>" data-orderable-trigger="cart" style="<?php echo esc_attr( $style ); ?>">
	<button class="orderable-floating-cart__button">
		<?php
		$svg_path = ORDERABLE_PATH . 'assets/icons/basket.svg';
		$svg_html = is_readable( $svg_path ) ? file_get_contents( $svg_path ) : ''; // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Plugin-shipped SVG asset.

		echo wp_kses(
			$svg_html,
			array(
				'svg'    => array(
					'xmlns'           => true,
					'viewbox'         => true,
					'width'           => true,
					'height'          => true,
					'fill'            => true,
					'fill-rule'       => true,
					'clip-rule'       => true,
					'shape-rendering' => true,
					'text-rendering'  => true,
					'image-rendering' => true,
					'class'           => true,
					'aria-hidden'     => true,
					'role'            => true,
				),
				'g'      => array(
					'fill'      => true,
					'fill-rule' => true,
					'clip-rule' => true,
				),
				'path'   => array(
					'd'            => true,
					'fill'         => true,
					'fill-rule'    => true,
					'clip-rule'    => true,
					'stroke'       => true,
					'stroke-width' => true,
				),
				'rect'   => array(
					'x'      => true,
					'y'      => true,
					'width'  => true,
					'height' => true,
					'fill'   => true,
					'rx'     => true,
					'ry'     => true,
				),
				'circle' => array(
					'cx'   => true,
					'cy'   => true,
					'r'    => true,
					'fill' => true,
				),
				'title'  => array(),
			)
		);
		?>
	</button>
	<span class="orderable-floating-cart__count"><?php echo wp_kses_data( $cart_count ); ?></span>
</div>
