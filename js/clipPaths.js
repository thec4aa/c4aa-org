/********************
Get Clip Path Heading Selectors
*********************/

// selectors added through Gutenberg editor
const headings = document.querySelectorAll( '.is-style-c4aa-clipPath-heading' );

// h1 elements without background image, and archive h2 titles
const entryTitles = document.querySelectorAll( 'header:not(.featured-image) h1.entry-title, .archive h2.entry-title' );

// widget titles
const widgetTitles = document.querySelectorAll('.widget-title');

// donate length titles
const donateLegendTitles = document.querySelectorAll('.give-form legend');

/********************
Get Clip Path Quote Selectors
*********************/

const blockquotes = document.querySelectorAll('.wp-block-quote, .wp-block-pullquote');

/********************
Get Clip Path Button Selectors
*********************/

// selectors added through Gutenberg editor
const defaultButtons = document.querySelectorAll( '.is-style-c4aa-clipPath-button a' );
const outlineButtons =   document.querySelectorAll( '.is-style-c4aa-clipPath-button-outline a');

/* Plug-in buttons
 	donate form (.give-form) buttons
	contact form (.wpcf7-form) buttons
 	newsletter subscribe button (#mc-embedded-subscribe)
 */
const formButtons =   document.querySelectorAll( '.give-form button, .give-form input[type="submit"], .wpcf7-form input[type="submit"], #mc-embedded-subscribe');


/********************
Store Clip Path Properties in Array
*********************/

const clipProperties = ['--topLeftX', '--topLeftY', '--topRightX', '--topRightY', '--bottomLeftX', '--bottomLeftY', '--bottomRightX', '--bottomRightY' ];

/************** 
Apply Clip Paths 
**************/

/* Headings */

addBlockClipPaths(entryTitles);
addBlockClipPaths(headings);
addBlockClipPaths(widgetTitles);
addBlockClipPaths(donateLegendTitles);
addBlockClipPaths(blockquotes);


/* Buttons */
addPlugInButtonClipPaths(formButtons);
addThemeButtonClipPaths(defaultButtons);
addThemeButtonClipPaths(outlineButtons);

/************** 
 Clip Path Helper Function 
**************/

//if no fixedPoint is set, then this function will generate an integer
function getRandomNum( min, max, fixedPoint = 0 ) {
  min = Math.ceil( min );
  max = Math.floor( max );
  let float = Math.floor(Math.random() * ( max - min ) ) + min;
	return float.toFixed( fixedPoint );
}

function addBlockClipPaths ( selector ) {

	selector.forEach( ( heading ) => {
		// rotate headings
		heading.style.setProperty( '--rotate', getRandomNum( -1.5, 2, 3 ) );
		
		// add clip path css properties
		clipProperties.forEach( ( property ) => {
				heading.style.setProperty( property, getRandomNum( 10, 20) );
		});
	});
}

function addThemeButtonClipPaths ( selector ) {
	selector.forEach( ( button ) => {
		// add clip path css properties
		clipProperties.forEach( ( property ) => {
				button.style.setProperty( property, getRandomNum( 10, 20) );
		});
	});
}

function addPlugInButtonClipPaths ( selector ) {

	selector.forEach( ( button ) => {

		// create container for dropshadow
		let wrapShadow = document.createElement('div');
		wrapShadow.setAttribute( 'class', 'is-style-c4aa-clipPath-button' );
	
		// insert container before button in the DOM tree
		button.parentNode.insertBefore( wrapShadow, button );
	
		// move button into container
		wrapShadow.appendChild( button );
	
		// add clip path css properties
		clipProperties.forEach( ( property ) => {
				button.style.setProperty( property, getRandomNum( 10, 20) );
		});
		
	});
}
