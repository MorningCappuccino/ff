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
		echo FilmAjaxModel::editFilmShowingInCinema($parameters);
	}

}
