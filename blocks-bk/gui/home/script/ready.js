$(function(){
	var tickerNoticias = $('.demo2').easyTicker({
		direction: 'down',
		easing: 'linear',
		speed: 'slow',
		visible: 3,
		height: 'auto',
		mousePause: 0,
		controls: {
			up: '.btnUp',
			down: '.btnDown',
			toggle: '.btnToggle'
		}
	});
	
	var tickObj = tickerNoticias.data('easyTicker');
	var tickOpts = tickObj.options;
	var total = $("#lista-noticias li").size();
	
	$('.btnVerMas').click(function(){
		if (tickOpts.visible + 2 <= total) {
			tickOpts.visible += 2;
		} else if (tickOpts.visible + 1 <= total) {
			tickOpts.visible++;
		}
	});
	
	$('.btnVerMenos').click(function(){
		if (tickOpts.visible > 1) {
			tickOpts.visible--;
		}
	});
	
	$('.btnToggle').click(function(){
		if ($('.btnToggle').text() == 'Play') {
			$('.btnToggle').text('Pause');
		} else {
			$('.btnToggle').text('Play');
		}
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
