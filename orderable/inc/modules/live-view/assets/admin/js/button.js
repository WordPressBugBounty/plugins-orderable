( function ( $ ) {
	'use strict';

	$( document ).ready( function () {
		if ( 'undefined' === typeof orderable_live_view_button_vars ) {
			return;
		}

		var $add_new_button = $( '.page-title-action' );

		if ( ! $add_new_button.length ) {
			return;
		}

		var enable_button  = orderable_live_view_button_vars.enable_button || '';
		var disable_button = orderable_live_view_button_vars.disable_button || '';
		var enable_audio   = orderable_live_view_button_vars.enable_audio || '';

		$add_new_button
			.after( enable_audio )
			.after( disable_button )
			.after( enable_button );
	} );
} )( jQuery );
