import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import './editor.scss';

export default function Edit( { attributes, setAttributes } ) {
	return (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody title={ __( 'Content', 'orderable' ) }>
					<ToggleControl
						label={ __( 'Show label', 'orderable' ) }
						checked={ attributes.showLabel }
						onChange={ ( value ) =>
							setAttributes( { showLabel: value } )
						}
					/>
					<TextControl
						label={ __( 'Label', 'orderable' ) }
						value={ attributes.label }
						onChange={ ( value ) =>
							setAttributes( { label: value } )
						}
					/>
					<TextControl
						label={ __( 'Subtotal Label', 'orderable' ) }
						value={ attributes.subtotalLabel }
						placeholder={ __( 'Subtotal: ', 'orderable' ) }
						onChange={ ( value ) =>
							setAttributes( { subtotalLabel: value } )
						}
					/>
					<TextControl
						label={ __( 'Discount Label', 'orderable' ) }
						value={ attributes.discountLabel }
						placeholder={ __( 'Discount: ', 'orderable' ) }
						onChange={ ( value ) =>
							setAttributes( { discountLabel: value } )
						}
					/>
					<TextControl
						label={ __( 'Total Label', 'orderable' ) }
						value={ attributes.totalLabel }
						placeholder={ __( 'Total: ', 'orderable' ) }
						onChange={ ( value ) =>
							setAttributes( { totalLabel: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>

			{ attributes.showLabel && (
				<div className="wp-block-orderable-receipt-layouts__label">
					{ attributes.label }
				</div>
			) }

			<div className="wp-block-orderable-order-totals__item">
				<span className="wp-block-orderable-receipt-layouts__label">
					{ attributes.subtotalLabel ||
						__( 'Subtotal: ', 'orderable' ) }
				</span>
				{ __( '$15.00', 'orderable' ) }
			</div>

			<div className="wp-block-orderable-order-totals__item">
				<span className="wp-block-orderable-receipt-layouts__label">
					{ attributes.discountLabel ||
						__( 'Discount: ', 'orderable' ) }
				</span>
				{ __( '-$2.00', 'orderable' ) }
			</div>

			<div className="wp-block-orderable-order-totals__item">
				<span className="wp-block-orderable-receipt-layouts__label">
					{ attributes.totalLabel || __( 'Total: ', 'orderable' ) }
				</span>
				{ __( '$13.00', 'orderable' ) }
			</div>
		</div>
	);
}
