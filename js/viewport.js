function setViewport() {
	const vh = window.innerHeight * 0.01;
	const vw = window.innerWidth * 0.01;

	document.documentElement.style.setProperty( '--vw', `${ vw }px` );
	document.documentElement.style.setProperty( '--vh', `${ vh }px` );
	// console.log( 'setViewport' );
}

function debouncedSetViewport( ms ) {
	let debounced;

	return function() {
		clearTimeout( debounced );
		debounced = setTimeout( setViewport, ms );
	};
}

window.addEventListener( 'resize', debouncedSetViewport( 250 ) );
setTimeout( setViewport, 500 );
