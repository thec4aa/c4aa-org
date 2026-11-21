wp.domReady( () => {

	wp.blocks.unregisterBlockStyle('core/button', 'outline');
	wp.blocks.unregisterBlockStyle('core/button', 'fill');
	wp.blocks.unregisterBlockStyle('core/separator', 'wide');

	wp.blocks.registerBlockStyle('core/button', {
		name: 'high-emphasis-button',
		label: 'High Emphasis',
		isDefault: true
	} );

	wp.blocks.registerBlockStyle('core/button', {
		name: 'low-emphasis-button',
		label: 'Low Emphasis',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle( 'core/heading', {
		name: 'c4aa-clipPath-heading',
		label: 'C4AA Banner',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle( 'core/list', {
		name: 'no-bullets',
		label: 'No Bullets',
		isDefault: false
	} );

	// Adding Random Rotation to Various Blocks
	
	wp.blocks.registerBlockStyle('core/group', {
		name: 'rotate-random',
		label: 'Random Rotation',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle('core/image', {
		name: 'rotate-random',
		label: 'Random Rotation',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle('core/button', {
		name: 'rotate-random',
		label: 'Random Rotation',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle('core/cover', {
		name: 'rotate-random',
		label: 'Random Rotation',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle('core/column', {
		name: 'rotate-random',
		label: 'Random Rotation',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle('core/list', {
		name: 'rotate-random',
		label: 'Random Rotation',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle('core/media-text', {
		name: 'rotate-random',
		label: 'Random Rotation',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle('core/paragraph', {
		name: 'rotate-random',
		label: 'Random Rotation',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle('core/post-featured-image', {
		name: 'rotate-random',
		label: 'Random Rotation',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle('core/quote', {
		name: 'rotate-random',
		label: 'Random Rotation',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle('core/separator', {
		name: 'rotate-random',
		label: 'Random Rotation',
		isDefault: false
	} );

	
	// Query Loop Block Styles
	// these cycle through background colors for the group blocks within them.

	wp.blocks.registerBlockStyle('core/query', {
		name: 'cycle-primary',
		label: 'Primary Cycle',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle('core/query', {
		name: 'cycle-primary-plus-blue',
		label: 'Primary + Blue',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle('core/query', {
		name: 'cycle-primary-plus-green',
		label: 'Primary + Green',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle('core/query', {
		name: 'cycle-primary-plus-purple',
		label: 'Primary + Purple',
		isDefault: false
	} );

	wp.blocks.registerBlockStyle('core/query', {
		name: 'cycle-primary-plus-yellow',
		label: 'Primary + Yellow',
		isDefault: false
	} );
});

// "Stack on tablet" toggle on core Columns, ported from the Multi Breakpoint
// Columns plugin. It only adds or removes the mbpc-collapse-tablet class; the
// CSS is in src/css/content/_columns.scss. Written against the wp.* globals
// because this file is loaded as is, not bundled.
( function () {
	const { createHigherOrderComponent } = wp.compose;
	const { createElement: el, Fragment, useEffect } = wp.element;
	const { InspectorControls, store: blockEditorStore } = wp.blockEditor;
	const { PanelBody, ToggleControl } = wp.components;
	const { useSelect } = wp.data;
	const STACK_CLASS = 'mbpc-collapse-tablet';

	const classList = ( className ) => ( className || '' ).split( /\s+/ ).filter( Boolean );
	const hasStackClass = ( className ) => classList( className ).includes( STACK_CLASS );
	const withStackClass = ( className, on ) => {
		const list = classList( className ).filter( ( c ) => c !== STACK_CLASS );
		if ( on ) {
			list.push( STACK_CLASS );
		}
		return list.join( ' ' );
	};

	const withStackOnTablet = createHigherOrderComponent( ( BlockEdit ) => ( props ) => {
		const { name, attributes, setAttributes, clientId } = props;
		const isColumns = 'core/columns' === name;
		// Like core's own stacking toggle, hidden until a layout has been picked.
		const hasInnerBlocks = useSelect(
			( select ) => isColumns && select( blockEditorStore ).getBlocks( clientId ).length > 0,
			[ isColumns, clientId ]
		);
		const enabled = isColumns && hasStackClass( attributes.className );

		// Stacking on tablet but not on mobile makes no sense, so when core's
		// mobile toggle goes off this one follows.
		useEffect( () => {
			if ( enabled && false === attributes.isStackedOnMobile ) {
				setAttributes( { className: withStackClass( attributes.className, false ) } );
			}
		}, [ attributes.isStackedOnMobile ] );

		if ( ! isColumns || ! hasInnerBlocks ) {
			return el( BlockEdit, props );
		}

		return el(
			Fragment,
			null,
			el( BlockEdit, props ),
			el(
				InspectorControls,
				null,
				el(
					PanelBody,
					null,
					el( ToggleControl, {
						__nextHasNoMarginBottom: true,
						label: wp.i18n.__( 'Stack on tablet', 'c4aa-org' ),
						checked: enabled,
						onChange: ( on ) =>
							setAttributes(
								on
									? { className: withStackClass( attributes.className, true ), isStackedOnMobile: true }
									: { className: withStackClass( attributes.className, false ) }
							),
					} )
				)
			)
		);
	}, 'withStackOnTablet' );

	wp.hooks.addFilter( 'editor.BlockEdit', 'c4aa/stack-on-tablet', withStackOnTablet );
} )();
