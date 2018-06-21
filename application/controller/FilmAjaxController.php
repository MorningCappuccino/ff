<?php
/**
 * Class FilmAjaxController
 */

class FilmAjaxController extends Controller {

	public function __construct()
	{
		parent::__construct();
    	// echo Auth::checkAuthenticationAjax();
	}


	public function rateFilm($parameters)
	{
		if ( Session::userIsLoggedIn() ) {
			$res = FilmAjaxModel::rateFilm($parameters);
			echo json_encode($res);
		} else {
			//user is NOT login
			echo json_encode(array('status' => 'redirect', 'to' => 'login'));
		}
	}

	public function editFilmShowingInCinema($parameters)
	{
		$res = FilmAjaxModel::editFilmShowingInCinema($parameters);
		echo $res;
	}

	public function addFilmShowingInCinema($parameters)
	{
		$res = FilmAjaxModel::addFilmShowingInCinema($parameters);
		echo $res;
	}

	public function deleteFilmShowingInCinema($parameters)
	{
		$res = FilmAjaxModel::deleteFilmShowingInCinema($parameters);
		echo $res;
	}

	public function getAllFilms()
	{
		$res = FilmModel::getAllFilms();
		echo json_encode($res);
	}

	public function getFilmsOfCinemaByDay($parameters)
    {
        //selectedDay
        $date = $parameters->date;
		$cinema_id = $parameters->cinema_id;

        $res = CinemaModel::getFilmsOfCinemaByDay($cinema_id, $date);
		echo json_encode($res);
    }

	public function getSeatsOfHall($parameters)
	{

		if ( Session::userIsLoggedIn() ) {
			$res = CinemaModel::getSeatsOfHall($parameters);
			echo json_encode($res);
		} else {
			//user is NOT login
			echo json_encode(array('status' => 'redirect', 'to' => 'login'));
		}

	}

	public function paySuccessfull()
	{
		$parameters = (object) array(
			'seat_ids' => explode(',', Request::post('seat_ids')),
			'order_date' => Request::post('order_date'),
			'price' => Request::post('price')
		);

		$this->View->render('payment/index', [
			'data' => CinemaModel::paySuccessfull($parameters)
		]);
	}

	public function deleteSession($parameters)
	{
		echo FilmAjaxModel::deleteSession($parameters);
	}


}
