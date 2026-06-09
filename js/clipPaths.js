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

/********************
Scroll Rotation Setup
*********************/

/*
 * Both the clip-path headings and the random-rotation images get a subtle
 * tilt that drifts as they scroll through the viewport — a ~3deg swing across
 * one viewport height, in a random direction per element, clamped to ±4deg.
 *
 * Headings drive a `--rotate` variable (so the CSS keeps its own translate),
 * while images get an inline transform. Honors prefers-reduced-motion by
 * leaving each element at its static base tilt.
 */

const MAX_ROTATION = 4; // hard cap — never tilt past this in either direction
const SWING_MIN = 2;    // smallest total drift across one viewport height
const SWING_MAX = 3.5;  // largest — each element picks somewhere in this range

const prefersReducedMotion = window.matchMedia(
	'(prefers-reduced-motion: reduce)'
).matches;

// elements registered for scroll-driven rotation, each with its own applier
const scrollRotaters = [];

function clamp( value, min, max ) {
	return Math.min( Math.max( value, min ), max );
}

// headings: update the variable the clip-path CSS already multiplies by 1deg
function applyVariableRotation( el, angle ) {
	el.style.setProperty( '--rotate', angle.toFixed( 3 ) );
}

// images/figcaptions: use the individual `rotate` property so we leave the
// `transform` free for CSS hover effects (duotone scale, etc.) to compose
function applyTransformRotation( el, angle ) {
	el.style.rotate = `${angle.toFixed( 2 )}deg`;
}

// give an element a random direction and swing, apply its starting tilt, and
// register it for scroll updates
function registerRotater( el, base, apply ) {
	const direction = Math.random() < 0.5 ? -1 : 1; // clockwise or counter
	const swing = SWING_MIN + Math.random() * ( SWING_MAX - SWING_MIN );
	apply( el, base );
	scrollRotaters.push( { el, base, direction, swing, apply } );
}

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
		// base tilt feeds the --rotate variable and drifts on scroll. Kept
		// small so base + drift stays within the ±4deg cap.
		const base = Math.random() * 3 - 1.5; // -1.5 to 1.5
		registerRotater( heading, base, applyVariableRotation );

		// add clip path css properties
		clipProperties.forEach( ( property ) => {
				heading.style.setProperty( property, getRandomNum( 10, 20) );
		});
	});
}

/*
 *
 * Randomly Rotate Elements
 *
 */

// selector for elements
const randomRotationElements = document.querySelectorAll(
	'article.type-people .entry-content .wp-block-advanced-columns-column__inner figure img, .u-rotate-random, .is-style-rotate-random, figcaption'
  );

// base range is wider here, narrowed to leave headroom for the drift
randomRotationElements.forEach( ( el ) => {
	const base = Math.random() * 5 - 2.5; // -2.5 to 2.5
	registerRotater( el, base, applyTransformRotation );
} );

/**************
 Scroll Rotation Loop
**************/

// Map each element's position in the viewport to a drift angle and apply it.
function updateScrollRotation() {
	const viewportHeight = window.innerHeight;

	scrollRotaters.forEach( ( { el, base, direction, swing, apply } ) => {
		const rect = el.getBoundingClientRect();
		const center = rect.top + rect.height / 2;

		// 0 when the element's center sits at the bottom of the viewport,
		// 1 when it reaches the top. Clamped so it holds steady off-screen.
		const progress = clamp( 1 - center / viewportHeight, 0, 1 );

		// center it: a -swing/2..+swing/2 drift, flipped per element
		// so neighbors lean opposite ways
		const drift = ( progress - 0.5 ) * swing * direction;
		const angle = clamp( base + drift, -MAX_ROTATION, MAX_ROTATION );

		apply( el, angle );
	} );
}

if ( !prefersReducedMotion && scrollRotaters.length ) {
	let ticking = false;

	// throttle to one update per frame, shared by scroll and resize
	function requestUpdate() {
		if ( !ticking ) {
			window.requestAnimationFrame( () => {
				updateScrollRotation();
				ticking = false;
			} );
			ticking = true;
		}
	}

	window.addEventListener( 'scroll', requestUpdate, { passive: true } );
	// recompute on resize since viewport height (and layout) can change
	window.addEventListener( 'resize', requestUpdate, { passive: true } );

	// set the tilt for whatever is already on screen at load
	updateScrollRotation();
}
