( function ( $ ) {
	'use strict';

	$( document ).ready( function () {
		if ( 'undefined' === typeof orderable_print_order_button_vars ) {
			return;
		}

		var button_html = orderable_print_order_button_vars.button_html || '';

		if ( ! button_html ) {
			return;
		}

		var $add_new_button = $( '.page-title-action' ).first();

		if ( $add_new_button.length ) {
			$add_new_button.before(
				'<span style="position:relative; top: -3px">' + button_html + '</span>'
			);
		}

		var $add_items = $( '.add-items' );

		if ( $add_items.length ) {
			$add_items.prepend(
				'<div style="float:left; margin-right:.25em">' + button_html + '</div>'
			);
		}
	} );
} )( jQuery );
