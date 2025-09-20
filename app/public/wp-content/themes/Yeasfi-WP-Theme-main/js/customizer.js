/* global wp, jQuery */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	$(window).scroll(function () {
		console.log($(window).scrollTop())
		if ($(window).scrollTop() > 63) {
		  $('.navbar').addClass('navbar-fixed');
		}
		if ($(window).scrollTop() < 64) {
		  $('.navbar').removeClass('navbar-fixed');
		}
	  });
	
}( jQuery ) );

