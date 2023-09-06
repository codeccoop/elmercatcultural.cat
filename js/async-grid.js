document.addEventListener( 'DOMContentLoaded', function() {
	const siteMain = document.getElementsByClassName( 'site-main' )[ 0 ];
	const content = siteMain.getElementsByClassName( 'async-grid' )[ 0 ];
	const postType = siteMain.id === 'event-archive' ? 'event' : 'workshop';

	const term = new State( 'all', () => {
		page.reset();
		onFilter( 'term' );
	} );
	const page = new State( 1, () => onFilter( 'page' ) );

	const filters = Array.apply( null, siteMain.getElementsByClassName( 'async-filter' ) );
	filters.forEach( function( btn ) {
		btn.addEventListener( 'click', onClickTerm );
	} );

	const pager = Array.apply( null, siteMain.getElementsByClassName( 'async-pager' ) )[ 0 ];
	onFilter();

	function onClickTerm( ev ) {
		term.value = ev.target.dataset.term;
	}

	function onClickPage( ev ) {
		page.value = ev.currentTarget.dataset.page;
		// window.scrollTo( 0, 0 );
	}

	function onFilter( src ) {
		const ajax = new XMLHttpRequest();
		ajax.onreadystatechange = function() {
			if ( this.readyState === 4 ) {
				if ( this.status === 200 ) {
					renderEvents( this.responseText )
						.then( ( data ) => {
							if ( src === 'page' && data.posts.length <= 6 ) {
								window.scrollTo( 0, 0 );
							}
						} )
						.then( onFilterSuccess )
						.catch( onFilterFails );
				} else {
					onFilterFails();
				}
			}
		};
		ajax.open( 'POST', ajax_data.ajax_url, true );
		ajax.setRequestHeader(
			'Content-Type',
			'application/x-www-form-urlencoded; charset=utf-8'
		);
		ajax.setRequestHeader( 'Accept', 'application/json; charset=utf-8' );
		ajax.withCredentials = true;
		ajax.send(
			encodePayload( {
				_ajax_nonce: ajax_data.nonce,
				action: 'get_grid_items',
				term: term.value,
				page: page.value,
				type: postType,
			} )
		);
	}

	function renderEvents( data ) {
		return new Promise( function( res, rej ) {
			try {
				data = JSON.parse( data );
				const posts = ( data.posts || [] ).map( ( e ) => {
					e.date = new Date( e.date );
					return e;
				} );
				const pages = data.pages || 0;
				if ( posts.length === 0 ) {
					rej( new Error( 'Empty response' ) );
				}
				content.innerHTML = '';
				for ( let i = 0, len = posts.length; i < len; i++ ) {
					content.appendChild( renderEvent( posts[ i ] ) );
				}
				content.setAttribute( 'data-rows', Math.ceil( posts.length / 3 ) );
				renderPages( pages );
				res( data );
			} catch ( err ) {
				rej( err );
			}
		} );
	}

	function renderEvent( datum ) {
		const el = document.createElement( 'figure' );
		el.classList.add( 'grid-item' );
		const anchor = document.createElement( 'a' );
		anchor.href = datum.url;
		const img = document.createElement( 'img' );
		img.src = datum.thumbnail;
		anchor.appendChild( img );
		const caption = document.createElement( 'figcaption' );
		caption.classList.add( 'small' );
		caption.innerHTML =
      '<b class="title is.3">' +
      datum.title +
      '</b>' +
      ( datum.date ? '<br/>Data: ' + datum.date.toLocaleDateString() : '' ) +
      ( datum.hour ? '<br/>Horari: ' + datum.hour : '' );

		anchor.appendChild( caption );
		el.appendChild( anchor );
		return el;
	}

	function renderPages( pages ) {
		pager.innerHTML = '';
		if ( pages <= 1 ) {
			return;
		} else if ( pages > 3 ) {
			renderNavButtons( pages );
		}

		let visible;
		if ( page.value <= 2 ) {
			visible = [ 1, 2, 3 ];
		} else if ( page.value === pages ) {
			visible = Array.apply( null, Array( 3 ) ).map( ( _, i ) => pages - ( 2 - i ) );
		} else {
			visible = Array.apply( null, Array( 3 ) ).map( ( _, i ) => page.value - 1 + i );
		}

		visible
			.filter( ( v ) => v <= pages )
			.map( renderPage )
			.map( ( c ) => pager.appendChild( c ) );
	}

	function renderPage( i ) {
		const li = document.createElement( 'li' );
		li.classList.add( 'async-page' );

		li.innerText = i;
		li.setAttribute( 'data-page', i );
		li.addEventListener( 'click', onClickPage );
		return li;
	}

	function renderNavButtons( pages ) {
		let html = '';
		if ( page.value > 2 ) {
			html += `<li class="async-nav-btn first" data-page="1"><i></i></li>
        <li class="async-nav-btn previous" data-page="${ page.value - 1 }"><i></i></li>`;
		}

		if ( page.value <= pages - 2 ) {
			html += `<li class="async-nav-btn next" data-page="${ page.value + 1 }"><i></i></li>
        <li class="async-nav-btn last" data-page="${ pages }"><i></i></li>`;
		}

		pager.innerHTML = html;
		for ( const btn of pager.getElementsByClassName( 'async-nav-btn' ) ) {
			btn.addEventListener( 'click', onClickPage );
		}
	}

	function onFilterSuccess() {
		filters.forEach( function( el ) {
			el.classList.remove( 'active' );
			if ( el.dataset.term === term.value ) {
				el.classList.add( 'active' );
			}
		} );

		for ( const p of pager.getElementsByClassName( 'async-page' ) ) {
			p.classList.remove( 'active' );
			if ( parseInt( p.dataset.page ) === page.value ) {
				p.classList.add( 'active' );
			}
		}
	}

	function onFilterFails( err ) {
		// console.log( err );
		content.innerHTML = "<h3>No s'han trobat esdeveniments</h3>";
		onFilterSuccess();
	}

	function encodePayload( data ) {
		return Object.keys( data )
			.reduce( function( acum, k ) {
				return acum.concat( encodeURIComponent( k ) + '=' + encodeURIComponent( data[ k ] ) );
			}, [] )
			.join( '&' );
	}
} );

function State( defaultValue, changeCallback ) {
	let _currentValue = defaultValue;
	const _changeCallback = changeCallback;

	const type = defaultValue.__proto__.constructor;

	Object.defineProperty( this, 'default', {
		value: defaultValue,
		writable: false,
		configurable: false,
	} );
	Object.defineProperty( this, 'value', {
		set( val ) {
			if ( _currentValue !== val ) {
				const from = _currentValue;
				const to = type( val );
				_currentValue = to;
				if ( _changeCallback ) {
					_changeCallback( to, from );
				}
			}
		},
		get() {
			return _currentValue !== undefined ? _currentValue : defaultValue;
		},
	} );

	this.reset = function() {
		_currentValue = defaultValue;
	};
}
