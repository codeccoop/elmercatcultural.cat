/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	const siteNavigation = document.getElementById( 'site-navigation' );

	// Return early if the navigation doesn't exist.
	if ( ! siteNavigation ) {
		return;
	}

	const button = siteNavigation.getElementsByTagName( 'button' )[ 0 ];

	// Return early if the button doesn't exist.
	if ( 'undefined' === typeof button ) {
		return;
	}

	const menu = siteNavigation.getElementsByTagName( 'ul' )[ 0 ];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	if ( ! menu.classList.contains( 'nav-menu' ) ) {
		menu.classList.add( 'nav-menu' );
	}

	// Toggle the .toggled class and the aria-expanded value each time the button is clicked.
	button.addEventListener( 'click', function() {
		siteNavigation.classList.toggle( 'toggled' );

		if ( button.getAttribute( 'aria-expanded' ) === 'true' ) {
			button.setAttribute( 'aria-expanded', 'false' );
		} else {
			button.setAttribute( 'aria-expanded', 'true' );
		}
	} );

	// Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
	document.addEventListener( 'click', function( event ) {
		const isClickInside = siteNavigation.contains( event.target );

		if ( ! isClickInside ) {
			siteNavigation.classList.remove( 'toggled' );
			button.setAttribute( 'aria-expanded', 'false' );
		}
	} );

	// Get all the link elements within the menu.
	const links = menu.getElementsByTagName( 'a' );

	// Get all the link elements with children within the menu.
	const linksWithChildren = menu.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

	// Toggle focus each time a menu link is focused or blurred.
	// for ( const link of links ) {
	// 	link.addEventListener( 'focus', toggleFocus, true );
	// 	link.addEventListener( 'blur', toggleFocus, true );
	// }

	//select close button
	const closeButton = document.getElementById('menu-close');
	// add event listener to each time a menu link with children receive a click.
	for ( const link of linksWithChildren ) {
		link.addEventListener( 'click', openSidebar);
	}
	/**
	 *Sets or removes class focus and displays veiled div and hiddens overflow to block scrolling
	 * @param  ev
	 */
	function openSidebar (ev) {
		ev.preventDefault();//to prevent navigation when you click an a element with children
		for ( const link of linksWithChildren ) {
			link.parentNode.classList.remove( 'focus'); //select parentNode of the a element, in this case a li element
		}
		ev.target.parentNode.classList.add('focus');
		closeButton.classList.add('focus');
		document.getElementsByClassName('veil')[0].classList.add('show');
		document.body.style.overflow='hidden';
		document.addEventListener('click', onClickOut);
	};
	/**
	 *removes class focus when clicking outside menu, hiddens div and allows scrolling
	 * @param  ev
	 */
	function onClickOut( ev) {
		if (! menu.contains(ev.target)) {//if we do not click on the menu, then remove classes
			for ( const link of linksWithChildren ) {
				link.parentNode.classList.remove( 'focus');
				closeButton.classList.remove('focus');
				document.getElementsByClassName( 'veil')[0].classList.remove('show');
				document.body.style.overflow = 'scroll';
			}
			document.removeEventListener('click', onClickOut);
		}
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		if ( event.type === 'focus' || event.type === 'blur' ) {
			let self = this;
			// Move up through the ancestors of the current link until we hit .nav-menu.
			while ( ! self.classList.contains( 'nav-menu' ) ) {
				// On li elements toggle the class .focus.
				if ( 'li' === self.tagName.toLowerCase() ) {
					self.classList.toggle( 'focus' );
				}
				self = self.parentNode;
			}
		}

		if ( event.type === 'touchstart' ) {
			const menuItem = this.parentNode;
			event.preventDefault();
			for ( const link of menuItem.parentNode.children ) {
				if ( menuItem !== link ) {
					link.classList.remove( 'focus' );
				}
			}
			menuItem.classList.toggle( 'focus' );
		}
	}
}() );
