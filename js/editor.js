wp.domReady( () => {

	wp.blocks.unregisterBlockStyle('core/button', 'outline');
	wp.blocks.unregisterBlockStyle('core/button', 'fill');

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

	wp.blocks.registerBlockStyle('core/group', {
		name: 'rotate-random',
		label: 'Random Rotation',
		isDefault: false
	} );

});
