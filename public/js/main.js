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
		success: function(data) {
			data = JSON.parse(data);

			if ( isRedirect(data.status) ) {
				redirectTo(data.to);
				return false;
			}

			if (data.status == 'success') {
				successBalloon();
			}

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
	var sessionLabel = $(this);

	var data = {
		controller_name: 'FilmAjax',
		action_name: 'deleteSession',
		session_id: $(this).attr('session-id')
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
				sessionLabel.remove();
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log('error');
		}
	});

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
	//fill label
	$('.cinema-shedule .calendar-day').text( formatForCalendarDay(new Date()) );
	$('.cinema-shedule .calendar-day').attr('order-date', formatDate( new Date() ));

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

				var res = formatForCalendarDay(date);
				//to label
				$('.cinema-shedule .calendar-day').text(res);

				$('.cinema-shedule .calendar-day').attr('order-date', formatDate(date));

				return res;
			},
			toValue: function (date, format, language) {
				var d = new Date(date);
				d.setDate(d.getDate() + 7);
				return new Date(d);
			}
		}
	})
	.on('changeDate', function(ev){
	    $(this).datepicker('hide');
		let selectedDate = $(this).datepicker('getDate');
		let modDate = formatDate(selectedDate);

		//trigger click on label
		$('.cinema-shedule .calendar-day').click();
		//send date to server
		showFilmsOfCinemaByDay(modDate);
	});

}

initDatePicker();

$('.cinema-shedule .calendar-day').on('click', function() {
	if ( $(this).hasClass('-opened') ) {
		datepicker.datepicker('hide');
		$(this).removeClass('-opened');
	} else {
		datepicker.datepicker('show');
		$(this).addClass('-opened');
	}

});

/********************************************************************
****************** get Films of Cinema by Day ***********************
********************************************************************/
function showFilmsOfCinemaByDay(date) {

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
			data = JSON.parse(data);
			$('.cinema-shedule .movies').empty();
			data.films.forEach(function(el) {
				$('.cinema-shedule .movies').append( showFilm(el) );
			});

			App.initSessionLabel();
			// App.initBuyTicketBtn();

		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log('error: ', jqXHR, textStatus, errorThrown);
		}
	});
}

function showFilm(film) {
	var template = $('.movie.-template').clone(true).removeClass('-template').css('display', '');
	var a = template.find('a.link-to-movie').attr('href');
	template.attr('id', film.film_id);
	template.find('a.link-to-movie').attr('href', a + film.film_id);
	template.find('.movie-info_title').text(film.film_name);
	template.find('.movie-info_rating').text(film.score);
	template.find('.genres').text(film.cat_name);
	template.find('.duration').text(film.duration_mod);
	template.find('.age-limit').text(film.age_limit);

	var sessions = template.find('.sessions');
	for (var key in film.film_sessions) {
		let session = film.film_sessions[key].slice(0, 5);
		sessions.append( $('<div/>', { class: 'session', text: session, 'session-id': key }) );
	};

	return template[0];
}

function showHall(data) {
	console.log(data);
	hallModal.modal('show');
	hallGrid.attr('hall-id', data[0].hall_id);

	// fill info section
	var info = $('.info-section');
	var cinema = $('.cinema');
	info.find('.cinema span').text( cinema.find('.cinema-name').text() );
	info.find('.movie span').text( curr_movie.find('.movie-info_title').text() );
	info.find('.date span').text( $('.calendar-day').text() );
	info.find('.time span').text( curr_session_text );

	//clear prev seats
	seats.empty();

	console.log(data);

	$(data).each(function(i, el) {
		let seat = $('<div/>', { class: 'hall-grid__item', text: el.seat_num, 'seat-id': el.seat_id })

		if (el.user != null) {
			seat.addClass('-bought');
		}

		seats.append(seat);
	});
}

function initSeats() {
	seats.find('.hall-grid__item').on('click', function() {

		if ( $(this).is('.-selected, .-bought') ) {
			$(this).removeClass('-selected');
		} else {
			$(this).addClass('-selected');
		}

		var selectedCount = 0;
		selected_seat_ids = [];
		seats.find('.hall-grid__item').each(function(i, el) {
			if ( $(el).hasClass('-selected') ) {
				selected_seat_ids.push( $(el).attr('seat-id') );
				selectedCount++;
			}
		});

		$('.pay-section .cost span').text(curr_price_to * selectedCount);
		$('.pay-section .cost').css('opacity', 1);

	});
}
// })();

/************************************
************ Variable ***************
*************************************/
var
// host = window.location.host,
host = 'http://ff/',
movie = $('.movie'),
cinema_id = $('input[name="cinema_id"]').val(),
curr_session_id = null,
curr_session_text = '',
curr_price_to = null,
curr_movie = '',
selected_seat_ids = [],
hallModal = $('#hall-modal'),
seats = hallModal.find('.hall-grid__seats'),
hallGrid = hallModal.find('.hall-grid');


var App = {
	init: function() {
		for (var prop in this) {
			if (prop != 'init') {
				this[prop]();
			}
		}
	},

	// init session label
	initSessionLabel: function() {
		var sessions = $('.movie .session');
		sessions.on('click', function() {
			sessions.each(function(i, el) {
				$(el).removeClass('-selected');
			});

			$(this).addClass('-selected');
			curr_session_id = $(this).attr('session-id');
			curr_session_text = $(this).text();
		});
	},

	// init buy ticket btn
	initBuyTicketBtn: function() {
		movie.find('.buy-ticket a').on('click', function() {
			var buyBtn = $(this);
			curr_movie = $(this).closest('.movie');

			if (curr_session_id == null) {
				// TODO: add alert "select session"
				console.log('message not session');
				return false;
			}

			let send_data = {
				controller_name: 'FilmAjax',
				action_name: 'getSeatsOfHall',
				cinema_id: cinema_id,
				film_id: curr_movie.attr('id'),
				session_id: curr_session_id
			}

			console.log(send_data);

			$.ajax({
				url: host + 'ajax.php',
				method: 'post',
				data: send_data,
				success: function(data) {
					// console.log(data);
					data = JSON.parse(data);

					if ( isRedirect(data.status) ) {
						redirectTo(data.to);
						return false;
					}

					showHall(data);
					initSeats();

					// set current price_to
					curr_price_to = buyBtn.parent().parent().find('input[name="price_to"]').val();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log('error');
				}
			});

		});
	},

	// pay button
	initPayBtn: function() {
		$('.btn-pay').on('click', function() {

			// check on selected seats
			if ( $('.hall-grid__item.-selected').lenght == 0 ) {
				// TODO: alert
				console.log('no seat selected');
				return false;
			}

			let send_data = {
				controller_name: 'FilmAjax',
				action_name: 'paySuccessfull',
				seat_ids: selected_seat_ids,
				order_date: $('.calendar-day').attr('order-date')
			}

			console.log(send_data);

			$.ajax({
				url: host + 'ajax.php',
				method: 'post',
				data: send_data,
				success: function(data) {
					data = JSON.parse(data);
					console.log(data);
					if (data.status === 'success') {
						successBalloon();
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log('error');
				}
			});

		});
	}

}

App.init();

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

function formatForCalendarDay(date) {
	var d = new Date(date);
	var options = {
		  month: 'long',
		  day: 'numeric',
		  weekday: 'long',
		  timezone: 'UTC'
	}
	var dayNum = d.getDate();
	var res = d.toLocaleString('ru', options);

	return res;
}

function isRedirect(status) {
	if (status == 'redirect') {
		return true;
	}

	return false;
}

function redirectTo(to) {
	window.location.href = window.location.origin + '/' + to;
	return false;
}
