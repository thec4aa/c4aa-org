/********************
Get Clip Path Heading Selectors
*********************/

// selectors added through Gutenberg editor
const headings = document.querySelectorAll( '.is-style-c4aa-clipPath-heading' );

// h1 elements without background image, and archive h2 titles
const entryTitles = document.querySelectorAll( 'header:not(.featured-image) h1.entry-title, .archive h2.entry-title' );

// widget titles
const widgetTitles = document.querySelectorAll('.widget-title');

/********************
Get Clip Path Quote Selectors
*********************/

const blockquotes = document.querySelectorAll('.wp-block-quote, .wp-block-pullquote');

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
addBlockClipPaths(blockquotes);



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

