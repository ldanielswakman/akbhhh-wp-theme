$(document).ready(function() {
	// sticky header scrolling behavior
	var didScroll;
	lastScrollTop = 0;
	delta = 5;
	navbarHeight = $('header').outerHeight();

	$(window).scroll(function(e) {
		didScroll = true;
	});
	setInterval(function() {
		if (didScroll) {
			hasScrolled();
			didScroll = false;
		}
	}, 250);
});

function hasScrolled() {
	st = $(this).scrollTop();

	if (Math.abs(lastScrollTop - st) <= delta) {
		return;
	}
	if (st > lastScrollTop && st > navbarHeight) {
		$('header').removeClass('nav-down').addClass('nav-up');
		$('#scrollhelper').fadeOut();
	} else {
		if(st + $(window).height() < $(document).height()) {
			$('header').removeClass('nav-up').addClass('nav-down');
		}
	}

	lastScrollTop = st;
}

// animating a width or height change from defined to auto
jQuery.fn.animateAuto = function(prop, speed, callback){
	var elem, height, width;
	return this.each(function(i, el){
		el = jQuery(el), elem = el.clone().css({"height":"auto","width":"auto"}).appendTo("body");
		height = elem.css("height"),
		width = elem.css("width"),
		elem.remove();

		if(prop === "height")
			el.animate({"height":height}, speed, callback);
		else if(prop === "width")
			el.animate({"width":width}, speed, callback);
		else if(prop === "both")
			el.animate({"width":width,"height":height}, speed, callback);
	});
}

// get query variable in javascript by reading the URL
function getQueryVariable(variable) {
	var query = window.location.search.substring(1);
	var vars = query.split("&");
	for (var i=0;i<vars.length;i++) {
		var pair = vars[i].split("=");
		if( pair[0] == variable ) { return pair[1]; }
	}
	return(false);
}

window.addEventListener('load', function () {
	FastClick.attach(document.body);
}, false);
