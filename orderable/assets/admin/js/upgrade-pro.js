( function ( $ ) {
	'use strict';

	$( document ).on( 'click', '.ordpro-upgrade-faqs__body-faq-header', function () {
		var $faq    = $( this ).closest( '.ordpro-upgrade-faqs__body-faq' );
		var is_open = $faq.hasClass( 'ordpro-upgrade-faqs__body-faq--open' );

		if ( is_open ) {
			$faq.find( '.ordpro-upgrade-faqs__body-faq-content' ).slideUp();
			$faq.removeClass( 'ordpro-upgrade-faqs__body-faq--open' );
		} else {
			$faq.find( '.ordpro-upgrade-faqs__body-faq-content' ).slideDown();
			$faq.addClass( 'ordpro-upgrade-faqs__body-faq--open' );
		}
	} );
} )( jQuery );
