/**
 * Thinking Canines – main theme script.
 *
 * Scroll animations: add one of these classes to any element to animate it
 * in once, the first time it scrolls into view (elements already in view
 * animate on page load):
 *
 *   animate-up     rises in from below
 *   animate-down   drops in from above
 *   animate-left   slides in from the left
 *   animate-right  slides in from the right
 *   animate-fade   fades in on the spot
 *
 * Elements that enter view together (e.g. a row of cards) are staggered.
 */
( function () {
	'use strict';

	// Starting offset for each animation class.
	var animations = {
		'animate-up': { y: 40 },
		'animate-down': { y: -40 },
		'animate-left': { x: -60 },
		'animate-right': { x: 60 },
		'animate-fade': {},
	};

	var selector = Object.keys( animations ).map( function ( name ) {
		return '.' + name;
	} ).join( ',' );

	var elements = document.querySelectorAll( selector );

	if ( ! elements.length ) {
		return;
	}

	var reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	// No GSAP (e.g. the CDN failed) or reduced motion: just show everything.
	if ( typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined' || reduceMotion ) {
		elements.forEach( function ( el ) {
			el.style.visibility = 'visible';
		} );
		return;
	}

	gsap.registerPlugin( ScrollTrigger );

	elements.forEach( function ( el ) {
		var from = { autoAlpha: 0 };

		Object.keys( animations ).forEach( function ( name ) {
			if ( el.classList.contains( name ) ) {
				Object.assign( from, animations[ name ] );
			}
		} );

		gsap.set( el, from );
	} );

	function reveal( batch ) {
		gsap.to( batch, {
			autoAlpha: 1,
			x: 0,
			y: 0,
			duration: 0.8,
			ease: 'power2.out',
			stagger: 0.12,
			overwrite: true,
			clearProps: 'transform',
		} );
	}

	ScrollTrigger.batch( selector, {
		start: 'top 88%',
		once: true,
		onEnter: reveal,
		// Covers elements above the viewport when the page loads part-way down.
		onEnterBack: reveal,
	} );
} )();
