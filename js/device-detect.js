function isMobile() {
	return /Mobile|iP(hone|od|ad)|Android|BlackBerry|IEMobile|Kindle|NetFront|Silk-Accelerated|(hpw|web)OS|Fennec|Minimo|Opera M(obi|ini)|Blazer|Dolfin|Dolphin|Skyfire|Zune/.test(
		navigator.userAgent
	);
}

function setIsMobile() {
	if ( isMobile() ) {
		document.body.classList.add( 'is-mobile' );
	} else {
		document.body.classList.remove( 'is-mobile' );
	}
}

window.addEventListener(
	'resize',
	( function() {
		let debounced;

		return function() {
			clearTimeout( debounced );
			debounced = setTimeout( setIsMobile, 100 );
		};
	}() )
);

setIsMobile();
