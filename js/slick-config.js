jQuery( document ).ready( function( $ ) {
	$('.front-portfolio .portfolio-wrapper').slick({
		infinite: true,
		slidesToShow: 2,
		slidesToScroll: 1,
		dots: false,
		speed: 1000,
		arrows: false,
		autoplay: true,
		autoplaySpeed: 4000,
		cssEase: 'linear',
		responsive: [{
			breakpoint: 1200,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
			}
		}],
	});
} );