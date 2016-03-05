(function(){
	"use strict";

//Rating system
$('#film-rating').rating({
	language: 'ru',
	min: 0,
	max: 10,
	step: 1,
	stars: 10,
	showCaption: true,
	starCaptions: {
		1: '1',
		2: '2',
		3: '3',
		4: '4',
		5: '5',
		6: '6',
		7: '7',
		8: '8',
		9: '9',
		10: '10'
	},
	showClear: false,
	starCaptionClasses: {
		1: 'label label-danger',
		2: 'label label-danger',
		3: 'label label-danger',
		4: 'label label-warning',
		5: 'label label-warning',
		6: 'label label-info',
		7: 'label label-info',
		8: 'label label-success',
		9: 'label label-success',
		10: 'label label-success'
	}
});

$('#film-rating').on('rating.change', function(event, value, caption) {
	var furl = window.location.href;
	var film_id = furl[furl.split('').length-1];
		// furl = furl[furl.length-1];
		// console.log(film_id);
		// console.log(caption);
		$.ajax({
			url: 'http://localhost/ff/ajax.php',
			method: 'post',
			data: { controller_name: 'FilmAjax',
			action_name: 'rateFilm',
			film_id: film_id,
			user_score: value
		},
		success: function(data){
			$('.response').html(data);
		}
	});
	});


})();