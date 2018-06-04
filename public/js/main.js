(function(){
	"use strict";

//Rating system
$('#film-rating').rating({
	language: 'ru',
	min: 0,
	max: 10,
	step: 1,
	stars: 10,
	size: 'xs',
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
			// url: window.location.host + '/ajax.php',
			url: host + 'ajax.php',
			method: 'post',
			data: { controller_name: 'FilmAjax',
			action_name: 'rateFilm',
			film_id: film_id,
			user_score: value
		},
		success: function(data){
			console.log(data);
			$('.response').html(data);
		}
	});
});

/************************************
************ Variable ***************
*************************************/
var
// host = window.location.host,
host = 'http://ff/';

/********************************************************************
************************** Add session ******************************
********************************************************************/
$('.fresh-movie .btn-add-session').on('click', function(ev) {
	let input = $(this).next();
	let newSes = input.val();
	let isValid = true;

	// wrong value
	if (newSes == '' || !/^\d\d:\d\d$/.test(newSes)) {
		inputWrongValue(input);
		return false;
	}

	// is Session exist in Session Pool (on front)
	let sesPool = $(this).parent().next().children();
	sesPool.children().each(function(i, el) {
		if ( $(el).text() == newSes ) {
			inputWrongValue(input, 'Такой сеанс уже существует');
			isValid = false;
			return false;
		}
	});

	// valid value
	if (isValid) {
		let div = $('<div/>', {
			class: 's-item new',
			text: newSes,
			click: function(){$(this).remove()}
		});

		$(sesPool).append(div);
	}
});

$('.fresh-movie .session-pool .s-item').on('click', function(ev) {
	$(this).remove();
});

/********************************************************************
************************** Edit film in Cinema ******************************
********************************************************************/
$('.fresh-movie .btn-edit-film').on('click', function(ev) {
	let filmID = $(this).attr('film-id');
	let eFilm = $(this).closest('.fresh-movie');

	let sessions = [];
	eFilm.find('.session-pool').children().each(function(i, el) {
		sessions.push( $(el).text() );
	});

	let data = {
		controller_name: 'FilmAjax',
		action_name: 'editFilmShowingInCinema',
		film_id: filmID,
		cinema_id: $(document).find('input[name=cinema_id]').val(),
		begin_date: eFilm.find('input[name=date_from]').val(),
		finish_date: eFilm.find('input[name=date_to]').val(),
		cost_from: eFilm.find('input[name=cost_from]').val(),
		cost_to: eFilm.find('input[name=cost_to]').val(),
		film_sessions: sessions
	}

	console.log(data);

	$.ajax({
		url: host + 'ajax.php',
		method: 'post',
		data: data,
		success: function(data) {
			data = JSON.parse(data);
			if (data.status === 'success') {
				successBalloon();
			}
			console.log(data);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log('error');
		}
	});

});

/********************************************************************
*********************** Add film in Cinema **************************
********************************************************************/
//prepare to add film (fetch films)
$('.fresh-movie .btn-prepare-to-add-film').on('click', function(ev) {
	let data = {
		controller_name: 'FilmAjax',
		action_name: 'getAllFilms'
	};

	$.ajax({
		url: host + 'ajax.php',
		method: 'post',
		data: data,
		success: function(data) {
			data = JSON.parse(data);
			console.log(data);
			//inset films to select
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log('error');
		}
	});
});

$('.fresh-movie .btn-add-film').on('click', function(ev) {
	let eFilm = $(this).closest('.fresh-movie');
	// let filmID = from select

	let sessions = [];
	eFilm.find('.session-pool').children().each(function(i, el) {
		sessions.push( $(el).text() );
	});

	let data = {
		controller_name: 'FilmAjax',
		action_name: 'addFilmShowingInCinema',
		film_id: filmID,
		cinema_id: $(document).find('input[name=cinema_id]').val(),
		begin_date: eFilm.find('input[name=date_from]').val(),
		finish_date: eFilm.find('input[name=date_to]').val(),
		cost_from: eFilm.find('input[name=cost_from]').val(),
		cost_to: eFilm.find('input[name=cost_to]').val(),
		film_sessions: sessions
	}

	$.ajax({
		url: host + 'ajax.php',
		method: 'post',
		data: data,
		success: function(data) {
			data = JSON.parse(data);
			if (data.status === 'success') {
				successBalloon();
			}
			console.log(data);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log('error');
		}
	});

});

/********************************************************************
************************ Helper functions ***************************
********************************************************************/

function inputWrongValue(input, message) {

	if (!message) {
		message = 'Неверное значение';
	}

	$(input).css('background', '#fbaaaa');
	$(input).val(message);

	setTimeout(function() {
		$(input).css('background', '');
		$(input).val('');
	}, 2000);
}

function successBalloon() {
	let alert = $('<div/>', { class: 'alert alert-success alert-baloon bounceIn', text: 'Успех' });
	$('body').append(alert);

	setTimeout(function() { alert.remove() }, 2000);
}

})();
