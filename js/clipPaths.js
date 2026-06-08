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

/*
 *
 * Randomly Rotate Elements
 *
 * Each element gets a random base tilt, then drifts subtly as it scrolls
 * through the viewport — a ~3deg swing across one viewport height, in a
 * random direction per element. The total tilt is clamped so it never
 * exceeds ±4deg. Honors prefers-reduced-motion by leaving the static tilt.
 *
 */

// selector for elements
const randomRotationElements = document.querySelectorAll(
	'article.type-people .entry-content .wp-block-advanced-columns-column__inner figure img, .u-rotate-random, .is-style-rotate-random, figcaption'
  );

const MAX_ROTATION = 4; // hard cap — never tilt past this in either direction
const SCROLL_SWING = 3; // total degrees of drift across one viewport height

const prefersReducedMotion = window.matchMedia(
	'(prefers-reduced-motion: reduce)'
).matches;

// Give each element a random base angle and scroll direction, and apply the
// starting tilt. Base range is narrowed to leave headroom for the drift.
const rotatingElements = Array.from(randomRotationElements).map((el) => {
	const base = Math.random() * 5 - 2.5; // -2.5 to 2.5
	const direction = Math.random() < 0.5 ? -1 : 1; // clockwise or counter
	el.style.transform = `rotate(${base.toFixed(2)}deg)`;
	return { el, base, direction };
});

function clamp(value, min, max) {
	return Math.min(Math.max(value, min), max);
}

// Map each element's position in the viewport to a drift angle and apply it.
function updateScrollRotation() {
	const viewportHeight = window.innerHeight;

	rotatingElements.forEach(({ el, base, direction }) => {
		const rect = el.getBoundingClientRect();
		const center = rect.top + rect.height / 2;

		// 0 when the element's center sits at the bottom of the viewport,
		// 1 when it reaches the top. Clamped so it holds steady off-screen.
		const progress = clamp(1 - center / viewportHeight, 0, 1);

		// progress 0..1 becomes a -1.5..1.5 swing, flipped per element
		const drift = (progress - 0.5) * SCROLL_SWING * direction;
		const angle = clamp(base + drift, -MAX_ROTATION, MAX_ROTATION);

		el.style.transform = `rotate(${angle.toFixed(2)}deg)`;
	});
}

if (!prefersReducedMotion && rotatingElements.length) {
	let ticking = false;

	window.addEventListener(
		'scroll',
		() => {
			if (!ticking) {
				window.requestAnimationFrame(() => {
					updateScrollRotation();
					ticking = false;
				});
				ticking = true;
			}
		},
		{ passive: true }
	);

	// set the tilt for whatever is already on screen at load
	updateScrollRotation();
}
