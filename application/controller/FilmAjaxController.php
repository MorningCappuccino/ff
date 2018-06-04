<?php
/**
 * Class FilmAjaxController
 */

class FilmAjaxController {

	public function __construct()
	{
     Auth::checkAuthentication();
	}


	public function rateFilm($parameters)
	{
		$res = FilmAjaxModel::rateFilm($parameters);
		echo $res;
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

	public function getAllFilms()
	{
		$res = FilmModel::getAllFilms();
		echo json_encode($res);
	}

}
