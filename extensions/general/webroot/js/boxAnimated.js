$(function() {
	$(".longdescription").mouseenter(function(){
		$(this).stop(true, true).animate({opacity:0.99}, 200);
	}).mouseleave(function(){
		$(this).stop(true, true).animate({opacity:0.0}, 200);
	})
});
