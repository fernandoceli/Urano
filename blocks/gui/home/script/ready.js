$(function() {
	$('.demo1').easyTicker({
		direction : 'up'
	});

	$('.demo2').easyTicker({
		direction : 'down',
		interval : 2000,
		speed : 'slow',
	});

	$('.demo3').easyTicker({
		visible : 1,
		interval : 4000
	});

	$('.demo4').easyTicker({
		direction : 'up',
		easing : 'easeOutBounce',
		interval : 2500
	});

	$('.demo5').easyTicker({
		direction : 'up',
		visible : 3,
		easing : 'easeInBack',
		controls : {
			up : '.btnUp',
			down : '.btnDown',
			toggle : '.btnToggle'
		}
	});
});

$(document)
		.ready(
				function() {

					var dd = $('.vticker').easyTicker({
						direction : 'up',
						easing : 'easeInOutBack',
						speed : 'slow',
						interval : 2000,
						height : 'auto',
						visible : 1,
						mousePause : 0,
						controls : {
							up : '.up',
							down : '.down',
							toggle : '.toggle',
							stopText : 'Stop !!!'
						}
					}).data('easyTicker');

					cc = 1;
					$('.aa')
							.click(
									function() {
										$('.vticker ul')
												.append(
														'<li>'
																+ cc
																+ ' Triangles can be made easily using CSS also without any images. This trick requires only div tags and some</li>');
										cc++;
									});

					$('.vis').click(function() {
						dd.options['visible'] = 3;

					});

					$('.visall').click(function() {
						dd.stop();
						dd.options['visible'] = 0;
						dd.start();
					});

				});