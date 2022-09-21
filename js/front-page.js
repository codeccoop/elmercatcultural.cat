document.addEventListener( 'DOMContentLoaded', function() {
	const jumbo = jQuery( '.front-page__jumbotron' );
	if ( jumbo.hasClass( 'slider' ) ) {
		jumbo.slick( {
			autoplay: true,
			autoplaySpeed: 3000,
			arrows: false,
			dots: true,
		} );
	}
} );
