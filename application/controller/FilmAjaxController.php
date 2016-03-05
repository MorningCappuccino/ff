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
		FilmAjaxModel::rateFilm($parameters);
	}

}