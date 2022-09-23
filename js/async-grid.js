document.addEventListener( 'DOMContentLoaded', function() {
	const siteMain = document.getElementsByClassName( 'site-main' )[ 0 ];
	const content = siteMain.getElementsByClassName( 'async-grid' )[ 0 ];
	const postType = siteMain.id === 'event-archive' ? 'event' : 'workshop';

	const term = new State( 'all', onFilter );
	const page = new State( 1, onFilter );

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
		page.value = ev.target.dataset.page;
	}

	function onFilter() {
		const ajax = new XMLHttpRequest();
		ajax.onreadystatechange = function() {
			if ( this.readyState === 4 ) {
				if ( this.status === 200 ) {
					renderEvents( this.responseText ).then( onFilterSuccess ).catch( onFilterFails );
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
				const posts = data.posts || [];
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
      '<label class="title is.3">' +
      datum.title +
      '</label><br/>' +
      'Inici: ' +
      ( datum.date || '12-07-2022' );
		// caption.innerText = datum.title;
		anchor.appendChild( caption );
		el.appendChild( anchor );
		return el;
	}

	function renderPages( pages ) {
		pager.innerHTML = '';
		if ( pages <= 1 ) {
			return;
		}
		for ( let i = 0; i < pages; i++ ) {
			pager.appendChild( renderPage( i ) );
		}
	}

	function renderPage( i ) {
		const li = document.createElement( 'li' );
		li.classList.add( 'async-page' );
		if ( page.value === i ) {
			li.classList.add( 'active' );
		}

		li.innerText = i + 1;
		li.setAttribute( 'data-page', i + 1 );
		li.addEventListener( 'click', onClickPage );
		return li;
	}

	function onFilterSuccess() {
		filters.forEach( function( el ) {
			el.classList.remove( 'active' );
			if ( el.dataset.term === term.value ) {
				el.classList.add( 'active' );
			}
		} );
	}

	function onFilterFails( err ) {
		console.log( err );
		content.innerHTML = "<h1>No s'han trobat esdeveniments</h1>";
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
	const history = [];
	Object.defineProperty( this, 'value', {
		set( val ) {
			if ( _currentValue !== val ) {
				const from = _currentValue;
				const to = val;
				_currentValue = val;
				if ( _changeCallback ) {
					_changeCallback( to, from );
				}
			}
		},
		get() {
			return _currentValue !== undefined ? _currentValue : defaultValue;
		},
	} );
}
