( function ( $ ) {
	'use strict';

	var orderable_date_picker = {
		/**
		 * On ready.
		 */
		ready: function () {
			orderable_date_picker.init();
			orderable_date_picker.watch();
		},

		/**
		 * Init datepicker.
		 */
		init: function () {
			if ( 'undefined' === typeof orderable_timings_daterangepicker ) {
				return;
			}

			var ranges = {};
			ranges[ orderable_timings_daterangepicker.today ]        = [ moment(), moment() ];
			ranges[ orderable_timings_daterangepicker.tomorrow ]     = [ moment().add( 1, 'days' ), moment().add( 1, 'days' ) ];
			ranges[ orderable_timings_daterangepicker.next_7_days ]  = [ moment(), moment().add( 6, 'days' ) ];
			ranges[ orderable_timings_daterangepicker.next_30_days ] = [ moment(), moment().add( 29, 'days' ) ];

			$( 'input[name="orderable_due_date"]' ).daterangepicker( {
				opens:               'left',
				autoUpdateInput:     false,
				alwaysShowCalendars: true,
				locale: {
					format:           'YYYY/MM/DD',
					cancelLabel:      orderable_timings_daterangepicker.clear,
					applyLabel:       orderable_timings_daterangepicker.apply,
					customRangeLabel: orderable_timings_daterangepicker.custom_range,
					daysOfWeek:       orderable_timings_daterangepicker.days_of_week,
					monthNames:       orderable_timings_daterangepicker.month_names,
				},
				ranges: ranges,
			} );
		},

		/**
		 * Watch datepicker events.
		 */
		watch: function () {
			$( document.body ).on( 'apply.daterangepicker', 'input[name="orderable_due_date"]', function ( ev, picker ) {
				$( this ).val( picker.startDate.format( 'YYYY/MM/DD' ) + ' - ' + picker.endDate.format( 'YYYY/MM/DD' ) );
			} );

			$( document.body ).on( 'cancel.daterangepicker', 'input[name="orderable_due_date"]', function () {
				$( this ).val( '' );
			} );
		}
	};

	$( document ).ready( orderable_date_picker.ready );
	$( document ).on( 'orderable-live-view-updated', orderable_date_picker.init );
} )( jQuery );
