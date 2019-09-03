const headings = document.querySelectorAll( 'h2, h3, h4, legend' );
const defaultButtons = document.querySelectorAll( 'button:not(.main-menu-more-toggle), .button, .wp-block-file__button, .wp-block-button:not(.is-style-outline), input[type="button"], input[type="reset"], input[type="submit"]' );
const outlineButtons =   document.querySelectorAll( '.wp-block-button.is-style-outline');
const outlineButtonsLink = document.querySelectorAll( '.wp-block-button.is-style-outline .wp-block-button__link');
const clipProperties = ['--topLeftX', '--topLeftY', '--topRightX', '--topRightY', '--bottomLeftX', '--bottomLeftY', '--bottomRightX', '--bottomRightY' ];


/* Heading Clip Paths */

headings.forEach( ( heading ) => {

	// rotate headings
	heading.style.setProperty( '--rotate', getRandomNum( -1.5, 2, 3 ) );
	
	// add clip path css properties
	clipProperties.forEach( ( property ) => {
			heading.style.setProperty( property, getRandomNum( 10, 20) );
	});
	
});


/* Button Clip Paths 

	because clip-paths eliminates drop shadows and borders, 
	wrappers are added to buttons to contain these properties

*/

defaultButtons.forEach( ( button ) => {

	// create container for dropshadow
	let wrapShadow = document.createElement('div');
	wrapShadow.setAttribute( 'class', 'c4aa-default-button-wrapper' );

	// insert container before button in the DOM tree
	button.parentNode.insertBefore( wrapShadow, button );

	// move button into container
	wrapShadow.appendChild( button );

	// add clip path css properties
	clipProperties.forEach( ( property ) => {
			button.style.setProperty( property, getRandomNum( 10, 20) );
	});
	
});

// add outline and shadow
outlineButtons.forEach( ( button ) => {

	button.classList.add( 'c4aa-outline-button-wrapper' );

});


outlineButtonsLink.forEach( ( link) => {
	
	clipProperties.forEach( ( property ) => {
			link.style.setProperty( property, getRandomNum( 10, 20) );
	});
	
});


/* Helper Function 

	if no fixedPoint is set, then this function will generate an integer

*/

function getRandomNum( min, max, fixedPoint = 0 ) {
  min = Math.ceil( min );
  max = Math.floor( max );
  let float = Math.floor(Math.random() * ( max - min ) ) + min;
	return float.toFixed( fixedPoint );
}