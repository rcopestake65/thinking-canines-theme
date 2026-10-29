/**
 * Thinking Canines – full-screen menu and photo gallery behaviour.
 */
( function () {
	'use strict';

	var menu = document.querySelector( '.site-menu' );
	var opener = document.querySelector( '[data-action="openMenu"]' );

	function hideMenu() {
		if ( ! menu ) {
			return;
		}
		menu.hidden = true;
		document.body.classList.remove( 'is-menu-open' );
		if ( opener ) {
			opener.setAttribute( 'aria-expanded', 'false' );
		}
	}

	function openMenu() {
		if ( ! menu ) {
			return;
		}
		menu.hidden = false;
		document.body.classList.add( 'is-menu-open' );
		if ( opener ) {
			opener.setAttribute( 'aria-expanded', 'true' );
		}
		var close = menu.querySelector( '[data-action="closeMenu"]' );
		if ( close ) {
			close.focus();
		}
	}

	function closeMenu() {
		hideMenu();
		if ( opener ) {
			opener.focus();
		}
	}

	function pad( x ) {
		return ( x < 10 ? '0' : '' ) + x;
	}

	function showSlide( gallery, index ) {
		var slides = JSON.parse( gallery.getAttribute( 'data-gallery' ) );
		var count = slides.length;
		var i = ( ( index % count ) + count ) % count;
		var slide = slides[ i ];

		gallery.setAttribute( 'data-index', String( i ) );

		var backdrop = gallery.querySelector( '.gallery__backdrop' );
		var img = gallery.querySelector( '.gallery__img' );
		if ( backdrop ) {
			backdrop.src = slide.src;
		}
		if ( img ) {
			img.src = slide.src;
			img.alt = slide.alt;
			img.removeAttribute( 'srcset' );
		}

		var counter = gallery.querySelector( '.gallery__counter' );
		if ( counter ) {
			counter.textContent = pad( i + 1 ) + ' / ' + pad( count );
		}

		var caption = gallery.querySelector( '.gallery__caption' );
		if ( caption ) {
			caption.textContent = slide.caption;
			caption.hidden = ! slide.caption;
		}

		gallery.querySelectorAll( '[data-action="pick"]' ).forEach( function ( thumb ) {
			if ( Number( thumb.getAttribute( 'data-index' ) ) === i ) {
				thumb.setAttribute( 'aria-current', 'true' );
			} else {
				thumb.removeAttribute( 'aria-current' );
			}
		} );
	}

	document.addEventListener( 'click', function ( e ) {
		var el = e.target.closest( '[data-action]' );
		if ( ! el ) {
			return;
		}
		var action = el.getAttribute( 'data-action' );

		if ( 'openMenu' === action ) {
			openMenu();
			return;
		}
		if ( 'closeMenu' === action ) {
			closeMenu();
			return;
		}
		if ( 'leaveMenu' === action ) {
			hideMenu();
			return;
		}

		var gallery = el.closest( '[data-gallery]' );
		if ( ! gallery ) {
			return;
		}
		var current = Number( gallery.getAttribute( 'data-index' ) ) || 0;
		if ( 'prev' === action ) {
			showSlide( gallery, current - 1 );
		} else if ( 'next' === action ) {
			showSlide( gallery, current + 1 );
		} else if ( 'pick' === action ) {
			showSlide( gallery, Number( el.getAttribute( 'data-index' ) ) );
		}
	} );

	// Pages restored from the back/forward cache start with the menu closed.
	window.addEventListener( 'pageshow', hideMenu );

	document.addEventListener( 'keydown', function ( e ) {
		if ( 'Escape' === e.key && menu && ! menu.hidden ) {
			closeMenu();
		}
	} );

	// Swipe support for galleries on touch screens.
	document.querySelectorAll( '[data-gallery] .gallery__stage' ).forEach( function ( stage ) {
		var x0 = null;
		stage.addEventListener( 'touchstart', function ( e ) {
			x0 = e.touches[ 0 ].clientX;
		}, { passive: true } );
		stage.addEventListener( 'touchend', function ( e ) {
			if ( null === x0 ) {
				return;
			}
			var dx = e.changedTouches[ 0 ].clientX - x0;
			var gallery = stage.closest( '[data-gallery]' );
			var i = Number( gallery.getAttribute( 'data-index' ) ) || 0;
			if ( Math.abs( dx ) > 40 ) {
				showSlide( gallery, dx < 0 ? i + 1 : i - 1 );
			}
			x0 = null;
		} );
	} );
} )();
