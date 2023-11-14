document.addEventListener( 'DOMContentLoaded', function() {
	jQuery( '.carroussel-content' ).slick( {
		infinite: true,
		speed: 300,
		//adaptiveHeight: true,
		slidesToShow: 1,
		centerMode: window.innerWidth > 980,
		variableWidth: window.innerWidth > 980,

		// centerMode: true,
		// variableWidth: true,
	} );

	if ( jQuery( '.carroussel-content' ).find( '.carroussel-image' ).length > 1 ) {
		jQuery( '.slides-numbers' ).addClass( 'show' );
	}

	jQuery( '.carroussel-content' ).on(
		'afterChange',
		function( event, slick, currentSlide ) {
			jQuery( '.carroussel-container' )
				.find( '.slides-numbers .active' )
				.html( currentSlide + 1 );
		}
	);

	const sliderItemsNum = jQuery( '.carroussel-content' )
		.find( '.slick-slide' )
		.not( '.slick-cloned' ).length;
	jQuery( '.carroussel-container' )
		.find( '.slides-numbers .total' )
		.html( sliderItemsNum );
} );
