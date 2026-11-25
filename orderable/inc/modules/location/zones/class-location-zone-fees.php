<?php
/**
 * Module: Location (Zone fees).
 *
 * @since  1.21.2
 * @package Orderable/Classes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Orderable_Location_Zone_Fees class.
 *
 * Stores each delivery zone's fee in an option keyed by zone ID. WooCommerce 10.5 stopped saving shipping
 * zone meta, which is where these fees used to live.
 */
class Orderable_Location_Zone_Fees {
	/**
	 * Option holding zone ID => delivery fee.
	 *
	 * @since 1.21.2
	 *
	 * @var string
	 */
	const OPTION = 'orderable_delivery_zone_fees';

	/**
	 * Meta key the fee was saved under before WooCommerce 10.5.
	 *
	 * @since 1.21.2
	 *
	 * @var string
	 */
	const LEGACY_META_KEY = 'delivery_fee';

	/**
	 * Init.
	 *
	 * @since 1.21.2
	 *
	 * @return void
	 */
	public static function run() {
		add_action( 'woocommerce_delete_shipping_zone', array( __CLASS__, 'delete' ) );
	}

	/**
	 * Get a zone's delivery fee.
	 *
	 * A fee saved before WooCommerce 10.5 lives in postmeta under the zone ID, where WooCommerce no longer
	 * reads it. It is copied into the option the first time it is read.
	 *
	 * @since 1.21.2
	 *
	 * @param int $zone_id The shipping zone ID.
	 * @return float
	 */
	public static function get( $zone_id ) {
		$zone_id = absint( $zone_id );

		if ( ! $zone_id ) {
			return 0.0;
		}

		$fees = self::all();

		if ( isset( $fees[ $zone_id ] ) ) {
			return (float) $fees[ $zone_id ];
		}

		$legacy_fee = get_post_meta( $zone_id, self::LEGACY_META_KEY, true );

		if ( '' === $legacy_fee || ! is_numeric( $legacy_fee ) ) {
			return 0.0;
		}

		return self::set( $zone_id, $legacy_fee );
	}

	/**
	 * Save a zone's delivery fee.
	 *
	 * @since 1.21.2
	 *
	 * @param int        $zone_id The shipping zone ID.
	 * @param string|int $fee     The fee, as entered; anything but digits and a decimal point is dropped.
	 * @return float The fee as saved.
	 */
	public static function set( $zone_id, $fee ) {
		$zone_id = absint( $zone_id );
		$fee     = self::sanitize( $fee );

		if ( ! $zone_id ) {
			return $fee;
		}

		$fees             = self::all();
		$fees[ $zone_id ] = $fee;

		update_option( self::OPTION, $fees );

		return $fee;
	}

	/**
	 * Delete a zone's delivery fee.
	 *
	 * @since 1.21.2
	 *
	 * @param int $zone_id The shipping zone ID.
	 * @return void
	 */
	public static function delete( $zone_id ) {
		$zone_id = absint( $zone_id );
		$fees    = self::all();

		if ( isset( $fees[ $zone_id ] ) ) {
			unset( $fees[ $zone_id ] );
			update_option( self::OPTION, $fees );
		}
	}

	/**
	 * Turn an entered fee into a non-negative amount rounded to cents.
	 *
	 * @since 1.21.2
	 *
	 * @param mixed $fee The fee as entered.
	 * @return float
	 */
	public static function sanitize( $fee ) {
		$fee = is_numeric( $fee ) ? $fee : wc_format_decimal( (string) $fee );

		return max( 0.0, round( (float) $fee, 2 ) );
	}

	/**
	 * All saved fees.
	 *
	 * @since 1.21.2
	 *
	 * @return array<int, float> Zone ID => fee.
	 */
	private static function all() {
		$fees = get_option( self::OPTION, array() );

		return is_array( $fees ) ? $fees : array();
	}
}
