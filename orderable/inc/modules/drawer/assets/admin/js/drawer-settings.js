( function ( $ ) {
	'use strict';

	$( document ).ready( function () {
		var $fields = {
			top:    $( '#orderable-fine-tune-cart-top' ),
			right:  $( '#orderable-fine-tune-cart-right' ),
			bottom: $( '#orderable-fine-tune-cart-bottom' ),
			left:   $( '#orderable-fine-tune-cart-left' )
		};

		if ( ! $fields.top.length ) {
			return;
		}

		function hide_fields() {
			$fields.top.closest( 'tr' ).hide();
			$fields.right.closest( 'tr' ).hide();
			$fields.bottom.closest( 'tr' ).hide();
			$fields.left.closest( 'tr' ).hide();
		}

		function show_fields( position ) {
			hide_fields();

			var $table = $fields.top.closest( 'table' );

			$table.closest( 'tr' ).show();

			if ( 'tr' === position ) {
				$fields.top.closest( 'tr' ).show();
				$fields.right.closest( 'tr' ).show();
			} else if ( 'br' === position ) {
				$fields.bottom.closest( 'tr' ).show();
				$fields.right.closest( 'tr' ).show();
			} else if ( 'bl' === position ) {
				$fields.bottom.closest( 'tr' ).show();
				$fields.left.closest( 'tr' ).show();
			} else if ( 'tl' === position ) {
				$fields.top.closest( 'tr' ).show();
				$fields.left.closest( 'tr' ).show();
			} else {
				$fields.top.closest( 'table' ).closest( 'tr' ).hide();
			}

			$table.find( 'tr' ).removeClass( 'orderable-table__row--last' );
			$table.find( 'tr' ).not( '[style*="display: none"]' ).last().addClass( 'orderable-table__row--last' );
		}

		var $position_field = $( '#style_cart_position' );

		show_fields( $position_field.val() );

		$position_field.on( 'change', function () {
			show_fields( $( this ).val() );
		} );
	} );
} )( jQuery );
