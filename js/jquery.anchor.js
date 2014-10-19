/*******

	***	Anchor Slider by Cedric Dugas   ***
	*** Http://www.position-absolute.com ***

	Never have an anchor jumping your content, slide it.

	Don't forget to put an id to your anchor !
	You can use and modify this script for any project you want, but please leave this comment as credit.

*****/



$(document).ready(function() {
	$("a[href^='#']").anchorAnimate()
});

jQuery.fn.anchorAnimate = function(settings) {
	// ADDED: if parameter is not defined when script is called, set default
	if ( typeof $spacingFromTop === 'undefined' ) { $spacingFromTop = 0; }

 	settings = jQuery.extend({
		speed : 700
	}, settings);

	return this.each(function(){
		var caller = this

		var touch = ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch;
		var touchEvent = touch ? 'touchstart' : 'click';
		$(caller).bind(touchEvent, (function(event) {
			event.preventDefault()
			var locationHref = window.location.href
			var elementClick = $(caller).attr("href")

			// ADDED: if statement so animation only works if news article is not being collapsed
			if (!$(this).closest('article').hasClass('active')) {

				var destination = $(elementClick).offset().top - $spacingFromTop;

				$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination}, settings.speed, function() {
					window.location.hash = elementClick
				});
			}
		  return false;
		}))
	})
}
