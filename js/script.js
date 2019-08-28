const headings = document.querySelectorAll( 'h2, h3, h4, legend' );

let clipProperties = ['--topLeftX', '--topLeftY', '--topRightX', '--topRightY', '--bottomLeftX', '--bottomLeftY', '--bottomRightX', '--bottomRightY' ];

headings.forEach( ( heading ) => {
	heading.style.setProperty( '--rotate', getRandomNum( -1.5, 2, 3 ) );
		
	clipProperties.forEach( ( property ) => {
			heading.style.setProperty( property, getRandomNum( 10, 20) );
	});
	
});

//if no fixedPoint is set, then this function will generate an integer
function getRandomNum( min, max, fixedPoint = 0 ) {
  min = Math.ceil( min );
  max = Math.floor( max );
  let float = Math.floor(Math.random() * ( max - min ) ) + min;
	return float.toFixed( fixedPoint );
}