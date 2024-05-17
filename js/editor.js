wp.domReady( () => {

	wp.blocks.unregisterBlockStyle('core/button', 'outline');
	wp.blocks.unregisterBlockStyle('core/button', 'fill');

	wp.blocks.registerBlockStyle('core/button', {
		name: 'high-emphasis-button',
		label: 'High Emphasis',
		isDefault: true
	} );
	  
	  wp.blocks.registerBlockStyle('core/button', {
		name: 'med-emphasis-button',
		label: 'Medium Emphasis'
	} );

	wp.blocks.registerBlockStyle('core/button', {
		name: 'low-emphasis-button',
		label: 'Low Emphasis'
	} );

	wp.blocks.registerBlockStyle( 'core/heading', {
		name: 'c4aa-clipPath-heading',
		label: 'C4AA Clip Path',
		isDefault: true,
	} );

});
