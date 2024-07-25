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
