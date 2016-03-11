$(function(){
	$('.demo2').easyTicker({
		direction: 'down',
		easing: 'linear',
		speed: 'slow',
	});
	
	$('.demo5').easyTicker({
		direction: 'up',
		visible: 3,
		easing: 'easeInBack',
		controls: {
			up: '.btnUp',
			down: '.btnDown',
			toggle: '.btnToggle'
		}
	});
});
