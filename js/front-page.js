document.addEventListener( 'DOMContentLoaded', function() {
	for ( const caption of document.querySelectorAll(
		'.front-page__jumbotron-item figcaption'
	) ) {
		spanLines( caption );
	}

	const jumbo = jQuery( '.front-page__jumbotron' );
	if ( jumbo.hasClass( 'slider' ) ) {
		jumbo.on( 'init', function( ev, slick ) {
			slick.slickPlay();
		} );
		jumbo.slick( {
			autoplay: true,
			draggable: true,
			autoplaySpeed: 3000,
			arrows: false,
			dots: true,
			mobileFirst: true,
		} );
	}

	function spanLines( el ) {
		const nodeLines = Array.from( el.childNodes )
			.filter( ( n ) => n.nodeType === 3 )
			.reduce( ( acum, node ) => {
				const range = document.createRange();
				const lines = [];
				const str = node.textContent;

				range.setStart( node, 0 );

				let prevBottom = range.getBoundingClientRect().bottom;
				let current = 1;
				let lastFound = 0;
				let bottom = 0;

				while ( current <= str.length ) {
					range.setStart( node, current );
					if ( current < str.length - 1 ) {
						range.setEnd( node, current + 1 );
					}
					bottom = range.getBoundingClientRect().bottom;
					if ( bottom > prevBottom ) {
						acum.push( str.substr( lastFound, current - lastFound ) );
						prevBottom = bottom;
						lastFound = current;
					}
					current++;
				}

				acum.push( str.substr( lastFound ) );

				return acum;
			}, [] );

		el.innerHTML = '';
		for ( const line of nodeLines ) {
			el.innerHTML += '<span>' + line + '</span>';
		}
	}
} );
