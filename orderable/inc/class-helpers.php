<?php
/**
 * Helper methods.
 *
 * @package Orderable/Classes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Helpers class.
 */
class Orderable_Helpers {
	/**
	 * Get term ID by slug.
	 *
	 * @param string $slug
	 * @param string $taxonomy
	 *
	 * @return int|bool
	 */
	public static function get_term_id_by_slug( $slug, $taxonomy = 'product_cat' ) {
		global $wpdb;

		$results = $wpdb->get_var(
			$wpdb->prepare(
				'SELECT DISTINCT t.term_id
			FROM wp_term_taxonomy AS tt
			INNER JOIN wp_terms AS t ON tt.term_id = t.term_id
			WHERE t.slug = %s
			AND tt.taxonomy = %s',
				$slug,
				$taxonomy
			)
		);

		return $results ? absint( $results ) : false;
	}

	/**
	 * Load classes.
	 *
	 * @param array  $classes Key = filename / Value = Class name.
	 * @param string $module  Module folder name.
	 */
	public static function load_classes( $classes, $module, $root = ORDERABLE_MODULES_PATH ) {
		foreach ( $classes as $file_name => $class_name ) {
			$path = $root . $module . '/class-' . $file_name . '.php';

			if ( ! file_exists( $path ) ) {
				continue;
			}

			require_once $path;

			if ( ! method_exists( $class_name, 'run' ) ) {
				continue;
			}

			$class_name::run();
		}
	}

	/**
	 * Get pro button.
	 *
	 * @param string $campaign
	 * @param string $text
	 * @param bool   $lock_icon
	 *
	 * @return string
	 */
	public static function get_pro_button( $campaign = '', $text = '', $lock_icon = true ) {
		$text      = empty( $text ) ? __( 'Available in Pro', 'orderable' ) : $text;
		$lock_icon = $lock_icon ? '<span class="dashicons dashicons-lock"></span>' : '';
		$url       = self::get_pro_url( $campaign );

		return sprintf( '<a href="%s" class="orderable-admin-button orderable-admin-button--pro" target="_blank">%s %s</a>', esc_url( $url ), $lock_icon, $text );
	}

	/**
	 * Get pro URL.
	 *
	 * @param string $campaign Campaign.
	 *
	 * @return string
	 */
	public static function get_pro_url( $campaign = '', $path = '' ) {
		$campaign = ! empty( $campaign ) ? sprintf( '&utm_campaign=%s', $campaign ) : '';

		return sprintf( 'https://orderable.com/%s?utm_source=Orderable&utm_medium=Plugin%s', $path, $campaign );
	}

	/**
	 * Prepare post type labels.
	 *
	 * @param array $labels
	 *
	 * @return array|bool
	 */
	public static function prepare_post_type_labels( $labels = array() ) {
		if ( empty( $labels ) ) {
			return false;
		}

		$singular = $labels['singular'];
		$plural   = $labels['plural'];

		return array(
			'name'                  => $plural,
			'singular_name'         => $singular,
			'menu_name'             => $plural,
			'name_admin_bar'        => $singular,
			'add_new'               => __( 'Add New', 'orderable' ),
			/* translators: %s - singular post type name. */
			'add_new_item'          => sprintf( __( 'Add New %s', 'orderable' ), $singular ),
			/* translators: %s - singular post type name. */
			'new_item'              => sprintf( __( 'New %s', 'orderable' ), $singular ),
			/* translators: %s - singular post type name. */
			'edit_item'             => sprintf( __( 'Edit %s', 'orderable' ), $singular ),
			/* translators: %s - singular post type name. */
			'view_item'             => sprintf( __( 'View %s', 'orderable' ), $singular ),
			'all_items'             => $plural,
			/* translators: %s - plural post type name. */
			'search_items'          => sprintf( __( 'Search %s', 'orderable' ), $plural ),
			/* translators: %s - plural post type name. */
			'parent_item_colon'     => sprintf( __( 'Parent %s:', 'orderable' ), $plural ),
			/* translators: %s - plural post type name (lowercased). */
			'not_found'             => sprintf( __( 'No %s found.', 'orderable' ), strtolower( $plural ) ),
			/* translators: %s - plural post type name (lowercased). */
			'not_found_in_trash'    => sprintf( __( 'No %s found in trash.', 'orderable' ), strtolower( $plural ) ),
			/* translators: %s - singular post type name. */
			'featured_image'        => sprintf( _x( '%s Featured Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'orderable' ), $singular ),
			'set_featured_image'    => _x( 'Set featured image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'orderable' ),
			'remove_featured_image' => _x( 'Remove featured image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'orderable' ),
			'use_featured_image'    => _x( 'Use as featured image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'orderable' ),
			/* translators: %s - plural post type name. */
			'archives'              => sprintf( _x( '%s archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'orderable' ), $plural ),
			/* translators: %s - singular post type name (lowercased). */
			'insert_into_item'      => sprintf( _x( 'Insert into %s', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'orderable' ), strtolower( $singular ) ),
			/* translators: %s - singular post type name (lowercased). */
			'uploaded_to_this_item' => sprintf( _x( 'Uploaded to this %s', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'orderable' ), strtolower( $singular ) ),
			/* translators: %s - plural post type name (lowercased). */
			'filter_items_list'     => sprintf( _x( 'Filter %s list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'orderable' ), strtolower( $plural ) ),
			/* translators: %s - plural post type name. */
			'items_list_navigation' => sprintf( _x( '%s list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'orderable' ), $plural ),
			/* translators: %s - plural post type name. */
			'items_list'            => sprintf( _x( '%s list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'orderable' ), $plural ),
		);
	}

	/**
	 * Custom kses method so we can also modify CSS properties allowed.
	 *
	 * @param string $content
	 * @param string $context
	 *
	 * @return string
	 */
	public static function kses( $content, $context = '' ) {
		if ( empty( $content ) ) {
			return $content;
		}

		// Modify allowed CSS.
		add_filter( 'safe_style_css', array( __CLASS__, 'safe_css' ) );

		$content = wp_kses( $content, self::kses_allowed_html( $context ) );

		// Disable CSS modification.
		remove_filter( 'safe_style_css', array( __CLASS__, 'safe_css' ) );

		return $content;
	}

	/**
	 * Sanitise output and allow form elements.
	 *
	 * @param string $context
	 *
	 * @return array
	 */
	public static function kses_allowed_html( $context = '' ) {
		$allowed_html = wp_kses_allowed_html( 'post' );

		if ( 'form' === $context ) {
			$allowed_attributes = array(
				'name'     => array(),
				'class'    => array(),
				'value'    => array(),
				'type'     => array(),
				'selected' => array(),
			);

			$allowed_html['span']   = $allowed_attributes;
			$allowed_html['select'] = $allowed_attributes;
			$allowed_html['option'] = $allowed_attributes;

			// Time-slot rows are toggled via inline style and tagged with data-orderable-period;
			// the frequency input also carries placeholder/min/max/step. Without these,
			// the orderable_get_time_slot_fields filter output (and Orderable Pro's override)
			// renders without hidden-row toggling and loses input hints.
			$allowed_html['input'] = array_merge(
				$allowed_attributes,
				array(
					'placeholder' => array(),
					'min'         => array(),
					'max'         => array(),
					'step'        => array(),
				)
			);

			$allowed_html['tr'] = array(
				'class'                 => array(),
				'style'                 => array(),
				'data-orderable-period' => array(),
			);

			$allowed_html['th'] = array(
				'class'   => array(),
				'colspan' => array(),
				'rowspan' => array(),
			);

			$allowed_html['td'] = array(
				'class'   => array(),
				'colspan' => array(),
				'rowspan' => array(),
				'style'   => array(),
			);

			$allowed_html['fieldset'] = array( 'class' => array() );
			$allowed_html['legend']   = array( 'class' => array() );
			$allowed_html['table']    = array( 'class' => array() );
			$allowed_html['thead']    = array();
			$allowed_html['tbody']    = array();
		}

		if ( 'frontend' === $context ) {
			$allowed_html = self::extend_kses_for_frontend( $allowed_html );
		}

		return $allowed_html;
	}

	/**
	 * Extend the post kses allowlist with the tags, attributes, and
	 * `data-*` attributes used by Orderable's frontend output (product
	 * cards, add-to-cart buttons, quantity rollers, etc.).
	 *
	 * Applied via `Orderable_Helpers::kses_allowed_html( 'frontend' )`,
	 * which is used to escape shortcode output without stripping the
	 * `data-orderable-*` attributes the JS depends on.
	 *
	 * @param array $allowed_html The base allowlist (post context).
	 * @return array
	 */
	protected static function extend_kses_for_frontend( $allowed_html ) {
		$common_attrs = array(
			'class'           => true,
			'id'              => true,
			'style'           => true,
			'role'            => true,
			'tabindex'        => true,
			'contenteditable' => true,
			'aria-label'      => true,
			'aria-hidden'     => true,
			'aria-expanded'   => true,
			'aria-controls'   => true,
			'title'           => true,
		);

		$data_attrs = array(
			'data-orderable-trigger'              => true,
			'data-orderable-product-id'           => true,
			'data-orderable-product-type'         => true,
			'data-orderable-variation-id'         => true,
			'data-orderable-variation-attributes' => true,
			'data-orderable-cart-item-key'        => true,
			'data-orderable-quantity'             => true,
			'data-orderable-product-quantity'     => true,
			'data-orderable-updating-quantity'    => true,
			'data-orderable-focus'                => true,
			'data-orderable-tabs'                 => true,
			'data-orderable-scroll-id'            => true,
			'data-orderable-day'                  => true,
			'data-orderable-time'                 => true,
			'data-orderable-time-slot-id'         => true,
			'data-orderable-period'               => true,
			'data-orderable-alt-text'             => true,
			'data-orderable-mute-status'          => true,
			'data-quantity'                       => true,
			'data-product_id'                     => true,
			'data-product_sku'                    => true,
			'data-product_name'                   => true,
			'data-cart_item_key'                  => true,
			'data-price'                          => true,
		);

		$tag_attrs = array_merge( $common_attrs, $data_attrs );

		$frontend_tags = array(
			'a',
			'button',
			'div',
			'span',
			'p',
			'img',
			'ul',
			'ol',
			'li',
			'h1',
			'h2',
			'h3',
			'h4',
			'h5',
			'h6',
			'strong',
			'em',
			'i',
			'b',
			'u',
			's',
			'small',
			'big',
			'br',
			'hr',
			'figure',
			'figcaption',
			'table',
			'thead',
			'tbody',
			'tfoot',
			'tr',
			'td',
			'th',
			'caption',
			'colgroup',
			'col',
			'dl',
			'dt',
			'dd',
			'section',
			'article',
			'aside',
			'header',
			'footer',
			'nav',
			'label',
			'fieldset',
			'legend',
			'form',
			'input',
			'select',
			'option',
			'optgroup',
			'textarea',
			'svg',
			'path',
			'rect',
			'g',
			'circle',
			'polygon',
			'line',
			'polyline',
			'use',
			'defs',
			'title',
			'del',
			'ins',
			'bdi',
			'mark',
		);

		foreach ( $frontend_tags as $tag ) {
			$existing                = isset( $allowed_html[ $tag ] ) && is_array( $allowed_html[ $tag ] ) ? $allowed_html[ $tag ] : array();
			$allowed_html[ $tag ]    = array_merge( $existing, $tag_attrs );
		}

		// Element-specific extras that aren't in `post` kses.
		$allowed_html['a'] = array_merge(
			$allowed_html['a'],
			array(
				'href'     => true,
				'target'   => true,
				'rel'      => true,
				'download' => true,
			)
		);

		$allowed_html['button'] = array_merge(
			$allowed_html['button'],
			array(
				'type'     => true,
				'name'     => true,
				'value'    => true,
				'disabled' => true,
			)
		);

		$allowed_html['form'] = array_merge(
			$allowed_html['form'],
			array(
				'action'       => true,
				'method'       => true,
				'enctype'      => true,
				'name'         => true,
				'target'       => true,
				'autocomplete' => true,
				'novalidate'   => true,
			)
		);

		$allowed_html['input'] = array_merge(
			$allowed_html['input'],
			array(
				'type'         => true,
				'name'         => true,
				'value'        => true,
				'placeholder'  => true,
				'required'     => true,
				'min'          => true,
				'max'          => true,
				'step'         => true,
				'checked'      => true,
				'disabled'     => true,
				'readonly'     => true,
				'pattern'      => true,
				'autocomplete' => true,
				'maxlength'    => true,
				'minlength'    => true,
				'size'         => true,
			)
		);

		$allowed_html['select'] = array_merge(
			$allowed_html['select'],
			array(
				'name'     => true,
				'multiple' => true,
				'required' => true,
				'disabled' => true,
				'size'     => true,
			)
		);

		$allowed_html['option'] = array_merge(
			$allowed_html['option'],
			array(
				'value'    => true,
				'selected' => true,
				'disabled' => true,
			)
		);

		$allowed_html['textarea'] = array_merge(
			$allowed_html['textarea'],
			array(
				'name'        => true,
				'rows'        => true,
				'cols'        => true,
				'placeholder' => true,
				'required'    => true,
				'maxlength'   => true,
				'disabled'    => true,
				'readonly'    => true,
			)
		);

		$allowed_html['img'] = array_merge(
			$allowed_html['img'],
			array(
				'src'        => true,
				'srcset'     => true,
				'sizes'      => true,
				'alt'        => true,
				'width'      => true,
				'height'     => true,
				'loading'    => true,
				'decoding'   => true,
				'fetchpriority' => true,
			)
		);

		// SVG and child elements (used by inline icons in frontend output).
		$svg_attrs = array(
			'xmlns'           => true,
			'viewbox'         => true,
			'width'           => true,
			'height'          => true,
			'fill'            => true,
			'fill-rule'       => true,
			'clip-rule'       => true,
			'stroke'          => true,
			'stroke-width'    => true,
			'shape-rendering' => true,
			'text-rendering'  => true,
			'image-rendering' => true,
			'class'           => true,
			'aria-hidden'     => true,
			'role'            => true,
		);

		$allowed_html['svg']  = array_merge( $allowed_html['svg'], $svg_attrs );
		$allowed_html['path'] = array_merge(
			$allowed_html['path'],
			array(
				'd'            => true,
				'fill'         => true,
				'fill-rule'    => true,
				'clip-rule'    => true,
				'stroke'       => true,
				'stroke-width' => true,
			)
		);
		$allowed_html['rect'] = array_merge(
			$allowed_html['rect'],
			array(
				'x'      => true,
				'y'      => true,
				'width'  => true,
				'height' => true,
				'fill'   => true,
				'rx'     => true,
				'ry'     => true,
			)
		);
		$allowed_html['g']      = array_merge( $allowed_html['g'], array( 'fill' => true ) );
		$allowed_html['circle'] = array_merge(
			$allowed_html['circle'],
			array(
				'cx'   => true,
				'cy'   => true,
				'r'    => true,
				'fill' => true,
			)
		);

		/**
		 * Filter the frontend kses allowlist.
		 *
		 * Use this filter to add tags, attributes, or `data-*` attributes that
		 * a theme or extension emits via Orderable's frontend hooks but that
		 * are not part of the default allowlist.
		 *
		 * @since 1.21.1
		 * @hook  orderable_frontend_kses_allowed_html
		 * @param array $allowed_html The kses allowlist.
		 * @return array
		 */
		return apply_filters( 'orderable_frontend_kses_allowed_html', $allowed_html );
	}

	/**
	 * Modify safe CSS values.
	 *
	 * @param array $safe_css
	 *
	 * @return array
	 */
	public static function safe_css( $safe_css = array() ) {
		$safe_css[] = 'display';

		return $safe_css;
	}

	/**
	 * Delete Orderable transients.
	 */
	public static function delete_orderable_transients() {
		global $wpdb;

		$wpdb->query(
			"
			DELETE FROM $wpdb->options
			WHERE option_name LIKE ('%%\_transient\_timeout\_orderable\_%%')
			OR option_name LIKE ('%%\_transient\_orderable\_%%')
		"
		);
	}

	/**
	 * Has notices?
	 *
	 * @return bool
	 */
	public static function has_notices() {
		return ! empty( WC()->session->get( 'wc_notices', array() ) );
	}

	/**
	 * Is a variable product type?
	 *
	 * @param string $product_type The product type.
	 * @return boolean
	 */
	public static function is_variable_product( $product_type ) {
		$variable_types = array(
			'variable',
			'variable-subscription',
		);

		/**
		 * Filter the variable types used by the is_variable_product function.
		 *
		 * @param array $variable_types The variable types.
		 *
		 * @return array New variable types.
		 * @since 1.4.0
		 * @hook  orderable_variable_types
		 */
		$variable_types = apply_filters( 'orderable_variable_types', $variable_types );

		return in_array( $product_type, $variable_types, true );
	}

	/**
	 * Is a variation product type?
	 *
	 * @param string $product_type The product type.
	 * @return boolean
	 */
	public static function is_variation_product( $product_type ) {
		$variation_types = array(
			'variation',
			'subscription_variation',
		);

		/**
		 * Filter the variable types used by the is_variable_product function.
		 *
		 * @param array $variation_types The variable types.
		 *
		 * @return array New variation types.
		 * @since 1.4.0
		 * @hook  orderable_variation_types
		 */
		$variation_types = apply_filters( 'orderable_variation_types', $variation_types );

		return in_array( $product_type, $variation_types, true );
	}

	/** Add image to media library.
	 *
	 * @param string $url                  URL.
	 * @param int    $associated_with_post Post ID if media is associated to post.
	 * @param string $file_name            File name.
	 *
	 * @return bool|int|WP_Error
	 */
	public static function add_to_media( $url, $associated_with_post = 0, $file_name = '' ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		$tmp        = download_url( $url );
		$post_id    = $associated_with_post;
		$file_array = array();

		// Set variables for storage.
		// fix file filename for query strings.
		preg_match( '/[^\?]+\.(jpg|jpe|jpeg|gif|png|apk)/i', $url, $matches );

		if ( empty( $matches ) ) {
			return false;
		}

		$file_array['name']     = ! empty( $file_name ) ? $file_name : basename( $matches[0] );
		$file_array['tmp_name'] = $tmp;

		// If error storing temporarily, unlink.
		if ( is_wp_error( $tmp ) ) {
			wp_delete_file( $file_array['tmp_name'] );

			return false;
		}

		// do the validation and storage stuff.
		$id = media_handle_sideload( $file_array, $post_id );

		// If error storing permanently, unlink.
		if ( is_wp_error( $id ) ) {
			wp_delete_file( $file_array['tmp_name'] );

			return false;
		}

		return $id;
	}

	/**
	 * Check for the template in theme if exits then returns the file path
	 * in theme, else returns the path in plugin.
	 *
	 * This function simplifies the path in the theme to orderable/{module-slug}/template.php.
	 * For example if the path of file in plugin is
	 * /inc/modules/drawer/templates/floating-cart.php then the path in the theme
	 * would be orderable/drawer/floating-cart.php.
	 *
	 * @param string $file File to load.
	 * @param string $module Module slug example 'addons-pro'. Default: false.
	 * @param bool   $pro    Whether to find the template in pro plugin. Default: false.
	 *
	 * @return string
	 */
	public static function get_template_path( $file, $module = false, $pro = false ) {
		// Look for the file in theme.
		// Remove 'templates/' if it exists in the start.
		if ( 'templates/' === substr( $file, 0, 10 ) ) {
			$file = substr( $file, 10 );
		}

		$theme_path = 'orderable/' . $file;

		if ( $module ) {
			$theme_path = sprintf( 'orderable/%s/%s', $module, $file );
		}

		// If template found in the theme, then return the theme path.
		$theme_template = locate_template( $theme_path );
		if ( $theme_template ) {
			return $theme_template;
		}

		// Else look in the plugin.

		if ( $pro && ! defined( 'ORDERABLE_PRO_PATH' ) ) {
			return false;
		}

		$orderable_path = $pro ? ORDERABLE_PRO_PATH : ORDERABLE_PATH;

		if ( $module ) {
			return sprintf( '%sinc/modules/%s/templates/%s', $orderable_path, $module, $file );
		} else {
			return $orderable_path . 'templates/' . $file;
		}
	}

	/**
	 * Get the allowed HTML tags to SVG.
	 *
	 * This function is usefull when we need to escape
	 * SVG elements using wp_kses().
	 *
	 * @return array
	 */
	public static function get_svg_allowed_html_tags() {
		$allowed_html_tags['svg'] = array(
			'xmlns'   => array(),
			'fill'    => array(),
			'height'  => array(),
			'width'   => array(),
			'viewbox' => array(),
		);

		$allowed_html_tags['g'] = array();

		$allowed_html_tags['circle'] = array(
			'cx' =>   array(),
			'cy' => array(),
			'r'  => array(),
		);

		$allowed_html_tags['rect'] = array(
			'x'         => array(),
			'y'         => array(),
			'rx'        => array(),
			'height'    => array(),
			'width'     => array(),
			'transform' => array(),
			'fill'      => array(),
		);

		$allowed_html_tags['path'] = array(
			'd'         => array(),
			'fill'      => array(),
			'fill-rule' => array(),
			'clip-rule' => array(),
		);

		/**
		 * Filter the allowed SVG tags.
		 *
		 * @since 1.18.0
		 * @hook orderable_allowed_svg_tags
		 * @param  array $allowed_html_tags The SVG allowed tags.
		 * @return array New value
		 */
		$allowed_html_tags = apply_filters( 'orderable_allowed_svg_tags', $allowed_html_tags );

		return $allowed_html_tags;
	}

	/**
	 * Check if a product is in the cart and return the cart item
	 * if true. Otherwise, it returns false.
	 *
	 * @param int $product_id The product ID.
	 * @return array|false
	 */
	public static function is_product_in_the_cart( $product_id ) {
		$cart_item = false;

		if ( is_admin() || empty( WC()->cart ) ) {
			return $cart_item;
		}

		foreach ( WC()->cart->get_cart() as $cart_item_data ) {
			if ( $product_id !== $cart_item_data['product_id'] ) {
				continue;
			}

			$cart_item = $cart_item_data;
			break;
		}

		return $cart_item;
	}

	/**
	 * Get product quantity in the cart.
	 *
	 * If the product type is variation, it returns
	 * the quantity based on the variable product (parent).
	 *
	 * @param in $product_id The product ID.
	 * @return int
	 */
	public static function get_product_quantity_in_the_cart( $product_id ) {
		$quantity = 0;

		if ( is_admin() && ! wp_doing_ajax() ) {
			return $quantity;
		}

		if ( empty( WC()->cart ) ) {
			return $quantity;
		}

		foreach ( WC()->cart->get_cart() as $cart_item ) {
			if ( $product_id !== $cart_item['product_id'] ) {
				continue;
			}

			$quantity += absint( $cart_item['quantity'] );
		}

		return $quantity;
	}

	/**
	 * Get product image 2x size.
	 *
	 * @param WC_Product $product   The product.
	 * @param string     $size_name The size name to compare with.
	 * @return array|false
	 */
	public static function get_product_image_2x( WC_Product $product, string $size_name ) {
		if ( ! $product->get_image_id() ) {
			return false;
		}

		$sizes = wp_list_sort(
			array_filter(
				wp_get_registered_image_subsizes(),
				function( $image_size ) {
					if ( empty( $image_size['height'] ) || empty( $image_size['width'] ) ) {
						return false;
					}

					if ( ! is_numeric( $image_size['height'] ) || ! is_numeric( $image_size['width'] ) ) {
						return false;
					}

					return true;
				}
			),
			[ 'width', 'height' ],
			'ASC',
			true
		);

		if ( empty( $sizes[ $size_name ]['width'] ) || empty( $sizes[ $size_name ]['height'] ) ) {
			return false;
		}

		if ( ! is_numeric( $sizes[ $size_name ]['width'] ) || ! is_numeric( $sizes[ $size_name ]['height'] ) ) {
			return false;
		}

		$width_2x  = 2 * $sizes[ $size_name ]['width'];
		$height_2x = 2 * $sizes[ $size_name ]['height'];

		foreach ( $sizes as $size_name => $size ) {
			if ( $size['width'] < $width_2x || $size['height'] < $height_2x ) {
				continue;
			}

			$image = wp_get_attachment_image_src( $product->get_image_id(), $size_name );

			if ( ! $image ) {
				continue;
			}
		}

		if ( empty( $image ) ) {
			return false;
		}

		$image = [
			'src'        => $image[0],
			'width'      => $image[1],
			'height'     => $image[2],
			'is_resized' => $image[3],
		];

		return $image;
	}

	/**
	 * Check the WooCommerce version
	 *
	 * @param string $version_to_compare The version to compare.
	 * @param string $operator           The operator to compare. The same operators used by `version_compare`.
	 * @return bool
	 */
	public static function woocommerce_version_compare( $version_to_compare, $operator ) {
		$woocommerce_version = WC()->version ?? false;

		if ( ! $woocommerce_version ) {
			return false;
		}

		return version_compare( $woocommerce_version, $version_to_compare, $operator );
	}
}
