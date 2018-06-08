// (function(){
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
*********************** Delete film in Cinema **************************
********************************************************************/

$('.fresh-movie .btn-del-film').on('click', function(ev) {
	let parent = $(this).parent();
	let btnChoice = parent.find('.btn-choice');

	if (btnChoice.css('display') == 'block') {
		btnChoice.fadeOut();
	} else {
		btnChoice.fadeIn();
	}

});

$('.fresh-movie .btn-del-film-no').on('click', function(ev) {
	$(this).parent().find('.btn-choice').fadeOut();
});

$('.fresh-movie .btn-del-film-yes').on('click', function(ev) {
	let filmID = $(this).attr('film-id');
	let eFilm = $(this).closest('.fresh-movie');

	let data = {
		controller_name: 'FilmAjax',
		action_name: 'deleteFilmShowingInCinema',
		film_id: filmID,
		cinema_id: $(document).find('input[name=cinema_id]').val()
	}

	// console.log(data);

	$.ajax({
		url: host + 'ajax.php',
		method: 'post',
		data: data,
		success: function(data) {
			data = JSON.parse(data);
			if (data.status === 'success') {
				successBalloon();
				eFilm.slideUp();
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log('error');
		}
	});

});


/********************************************************************
*********************** Init calendar filter  ***********************
********************************************************************/
let datepicker = $('.cinema-shedule .calendar-filter input');

function initDatePicker() {
	$('.cinema-shedule .calendar-filter input').datepicker({
		container: '.calendar-filter',
		startDate: new Date(),
		// autoclose: true,
		orientation: "bottom right",
		format: {
			/*
			 * Say our UI should display a week ahead,
			 * but textbox should store the actual date.
			 * This is useful if we need UI to select local dates,
			 * but store in UTC
			 */
			toDisplay: function (date, format, language) {
				var d = new Date(date);
				d.setDate(d.getDate() - 7);
				return d.toISOString();
			},
			toValue: function (date, format, language) {
				var d = new Date(date);
				d.setDate(d.getDate() + 7);
				return new Date(d);
			}
		}
	})
	.on('changeDate', function(ev){
		console.log(this);
	    $(this).datepicker('hide');
		let selectedDate = $(this).datepicker('getDate');
		let modDate = formatDate(selectedDate);
		console.log(modDate);
		getFilmsOfCinemaByDay(modDate);
	});

}

initDatePicker();

$('.cinema-shedule .calendar-day').on('click', function() {
	datepicker.datepicker('show');
});

/********************************************************************
****************** get Films of Cinema by Day ***********************
********************************************************************/
function getFilmsOfCinemaByDay(date) {

	var data = {
		controller_name: 'FilmAjax',
		action_name: 'getFilmsOfCinemaByDay',
		cinema_id: $(document).find('input[name=cinema_id]').val(),
		date: date
	}

	console.log(data);

	$.ajax({
		url: host + 'ajax.php',
		method: 'post',
		data: data,
		success: function(data) {
			console.log(data);
			// data = JSON.parse(data);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log('error: ', jqXHR, textStatus, errorThrown);
		}
	});
}
// })();

/************************************
************ Variable ***************
*************************************/
var
// host = window.location.host,
host = 'http://ff/';


/********************************************************************
********************* Add film in Cinema ***************************
********************************************************************/
//prepare to add film (fetch filmsd)
$('.add-edit-wrap .btn-prepare-to-add-film').on('click', function(ev) {

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
			//create new container for film
			if ( $('.fresh-movie.new').length == 0 ) {
				$('.fresh-movie.template').clone(true).show().addClass('new').appendTo('.film-showing-in-cinema');
			}

			//inset films to select
			let newFilm = $('.fresh-movie.new');
			let select = newFilm.find('select[name=film_id]');
			data.forEach(function(el) {
				$('<option/>', { value: el.id, text: el.film_name }).appendTo(select);
			});

		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log('error');
		}
	});
});

function btnAddFilm(form) {
	let eFilm = $(form).closest('.fresh-movie.new');
	let filmID = eFilm.find('select[name=film_id]').val();

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

	console.log(data);

	$.ajax({
		url: host + 'ajax.php',
		method: 'post',
		data: JSON.stringify(data),
		// contentType: 'application/json',
		// dataType: 'json',
		success: function(data) {
			console.log(data);
			data = JSON.parse(data);
			if (data.status === 'success') {
				successBalloon();
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log('error: ', jqXHR, textStatus, errorThrown);
		}
	});

}

/********************************************************************
********************* Edit film in Cinema ***************************
********************************************************************/
function btnEditFilm(form) {
	let filmID = $(form).attr('film-id');
	let eFilm = $(form).closest('.fresh-movie');

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

}

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

//return date in string format 2018-05-18
function formatDate(date) {
	let year = date.getFullYear();
	let month = ("0" + (date.getMonth() + 1)).slice(-2);
	let day = ("0" + date.getDate()).slice(-2);

	return year + '-' + month + '-' + day;
}
