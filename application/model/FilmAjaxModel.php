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
			return 'success rate';
		}

		fail:
		Session::add('feedback_negative', Text::get('FEEDBACK_CREATION_FAILED'));
		return false;
	}

	public static function editFilmShowingInCinema($parameters)
	{
		if ($parameters) {

			$database = DatabaseFactory::getFactory()->getConnection();

			// try {

				/*
					Add film sessions
				*/
				// first: delete all session for curr film_id and cinema_id
				$sql = "DELETE * FROM film_session WHERE film_id = :film_id AND cinema_id = :cinema_id";
				$query = $database->prepare($sql);
				$query->execute(array(':film_id' => $parameters->film_id, ':cinema_id' => $parameters->cinema_id));

				// second: add new session for curr film_id and cinema_id
				foreach ($parameters->film_sessions as $session) {
					$sql = "INSERT INTO film_session (film_id, cinema_id, film_session) VALUES (:film_id, :cinema_id, :film_session)";
					$query = $database->prepare($sql);
					$query->execute(array(':film_id' => $parameters->film_id, ':cinema_id' => $parameters->cinema_id, ':film_session' => $session));
				}

			// } catch (Exception $err) {
				// header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
				// return $err;
			// }

			// if ($query->rowCount() == 1) {
			// 	return true;
			// }

		}


	}
}
