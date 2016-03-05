<?php

/**
 *
 */

class FilmAjaxModel
{
	public static function rateFilm($parameters)
	{
		if (!$parameters) {
			goto fail;
		}

		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "INSERT INTO link_user_film_score (film_id, user_id, score) VALUES (:film_id, :user_id, :score)";
		$query = $database->prepare($sql);
		$query->execute(array(':film_id' => $parameters->film_id, ':user_id' => Session::get('user_id'),
																															':score' => $parameters->user_score)
												 );

		if ($query->rowCount() == 1) {
			return true;
		}

		fail:
		Session::add('feedback_negative', Text::get('FEEDBACK_CREATION_FAILED'));
		return false;
	}
}