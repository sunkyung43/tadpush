var layerDepth = 0;

$(document).ready(function() {
	initLoadingBar();
});

function initLoadingBar() {
	$("#loading").ajaxStart(function() {
		loadingBarHide();
		loadingBarShow();
	}).ajaxStop(function() {
		loadingBarHide();
	});
}

function loadingBarShow() {
	var maskHeight = $(document).height();
	var maskWidth = $(window).width();

	$("#loading_bg").fadeTo(0, 0);

	$("#loading").show();
}

function loadingBarHide() {
	$("#loading").hide();
	$("#loading_bg").hide();
}

function showPopup(id, scroll) {
	if (typeof (id) == 'undefined') {
		return;
	}

	if (id.charAt(0) != '#') {
		id = '#' + id;
	}

	if ($(id).css('display') != 'none') {
		return;
	}
	$(id).css("overflow-x", "hidden");

	if ($(id).height() > window.innerHeight) {
		$(id).css("height", window.innerHeight);
		$(id).css("overflow-y", "auto");
	} else {
		$(id).css("height", '');
		$(id).css("overflow-y", "auto");
	}

//	$('html, body').scrollTop(0);
	var height = $(id).height() <= $(window).height() ? $(id).height() : $(
			window).height();
	var x = ($(window).scrollLeft() + ($(window).width() - $(id).width()) / 2);
	var y = ($(window).scrollTop() + ($(window).height() - height) / 2);

	if (x < 0) {
		x = 0;
	}

	if (y < 0) {
		y = 0;
	}

	$(id).css("left", x);
	$(id).css("top", y);

	$(id).css("max-height", $(window).height() - (($(window).height() - height) / 2));
	// $(id).children().eq(0).css("max-height", $(window).height() - y - 20);

	// $('html, body').animate({scrollTop:0}, 'slow'); 애니메이션
	$("body").css({
		overflow : 'hidden'
	})
	$(id).show();

	popupMaskShow();
}

function hidePopup(id) {
	if (typeof (id) == 'undefined') {
		return;
	}

	if (id.charAt(0) != '#') {
		id = '#' + id;
	}

	if ($(id).css('display') == 'none') {
		return;
	}

	$("body").css({
		overflow : 'inherit'
	})
	$(id).hide();

	popupMaskHide();
}

function popupMaskShow() {
	if (layerDepth == 0) {
		$("#mask").fadeTo(0, 0.6);
	} else if (layerDepth == 1) {
		$("#mask2").fadeTo(0, 0.6);
	}

	layerDepth++;
}

function popupMaskHide() {
	if (layerDepth == 1) {
		$("#mask").hide();
	} else if (layerDepth == 2) {
		$("#mask2").hide();
	}

	layerDepth--;

	if (layerDepth < 0) {
		layerDepth = 0;
	}
}

function tooltipPopup(id, show) {
	if (show) {
		$("#" + id).show();
	} else {
		$("#" + id).hide();
	}
}
