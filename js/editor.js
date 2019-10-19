var imageFilters = [
	'red-and-black',
	'beige-and-black',
	'beige-and-red',
	'beige-and-grey',
	'beige-and-grey-vintage'
];

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
	
	imageFilters.forEach( ( filter) => {
		wp.blocks.registerBlockStyle( 'core/image', {
			name: 'c4aa-duotone-' + filter,
			label: 'C4AA Duotone Filter: ' + filter,
			isDefault: false,
		} );
	});
} );