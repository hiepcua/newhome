/* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
// var prevScrollpos = window.pageYOffset;
// window.onscroll = function() {
//    var currentScrollPos = window.pageYOffset;
//    if (prevScrollpos > currentScrollPos) {
//     document.getElementById("body").classList.add("layout-navbar-fixed");
// } else {
//    document.getElementById("body").classList.remove("layout-navbar-fixed");
// }
// prevScrollpos = currentScrollPos;
// }
function gotopage(page)
{
	document.getElementById("txtCurnpage").value=page;
	document.frmpaging.submit();
}
;(function(){
	var win = $(window),
	html = $('html'),
	body = $('body'),
	btnMenu = $('.btn--menu'),
	mainMenu = $('#siteNavigation');

	$('.btn-mobile-site-search').on('click', function () {
		$('#ip-search-home').focus();
		// body.addClass('input-mode');
		// $('body').bind('touchmove', function(e){e.preventDefault();});
	});

	$('.carousel').carousel({
		interval: 4000
	});

	$('.post-thumb-120, .wrap-thumb-220, .big-post-thumb, .wrap-thumb, .i-wrap-thumb').each(function(){
		var url = $(this).attr('data-src');
		if(url !== undefined && url.length > 0){
			$(this).css('background-image', 'url('+url+')');
			$(this).find('img').css('display', 'none');
		}
	});
})(document, window, jQuery);
