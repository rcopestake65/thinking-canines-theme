/**
 * Thinking Canines – main theme script.
 *
 * Add data-animate to any element to fade it up as it scrolls into view.
 */
( function () {
	'use strict';

	if ( typeof gsap === 'undefined' ) {
		document.querySelectorAll( '[data-animate]' ).forEach( function ( el ) {
			el.style.visibility = 'visible';
		} );
		return;
	}

	gsap.registerPlugin( ScrollTrigger );

	var reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	gsap.utils.toArray( '[data-animate]' ).forEach( function ( el ) {
		if ( reduceMotion ) {
			gsap.set( el, { autoAlpha: 1 } );
			return;
		}

		gsap.fromTo(
			el,
			{ autoAlpha: 0, y: 40 },
			{
				autoAlpha: 1,
				y: 0,
				duration: 0.8,
				ease: 'power2.out',
				scrollTrigger: {
					trigger: el,
					start: 'top 85%',
					once: true,
				},
			}
		);
	} );
} )();
