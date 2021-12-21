wp.domReady( () => {
	
	wp.blocks.unregisterBlockStyle( 'core/button', 'outline' );
	wp.blocks.unregisterBlockStyle( 'core/button', 'squared' );
	
	wp.blocks.registerBlockStyle( 'core/heading', {
		name: 'c4aa-clipPath-heading',
		label: 'C4AA Clip Path',
		isDefault: true,
	} );
	
	wp.blocks.registerBlockStyle( 'core/button', {
		name: 'c4aa-clipPath-button',
		label: 'C4AA Clip Path Default',
		isDefault: false,
	} );
	
	wp.blocks.registerBlockStyle( 'core/button', {
		name: 'c4aa-clipPath-button-outline',
		label: 'C4AA Clip Path Outline',
		isDefault: false,
	} );
	
	wp.blocks.registerBlockStyle( 'core/cover', {
		name: 'c4aa-simple-filter',
		label: 'C4AA Simple Filter',
		isDefault: false,
	} );

} );