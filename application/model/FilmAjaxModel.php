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
				$sql = "DELETE FROM film_session WHERE film_id = :film_id AND cinema_id = :cinema_id";
				$query = $database->prepare($sql);
				$query->execute(array(':film_id' => $parameters->film_id, ':cinema_id' => $parameters->cinema_id));

				// second: add new session for curr film_id and cinema_id
				foreach ($parameters->film_sessions as $session) {
					self::addFilmSession($database, $parameters->cinema_id, $parameters->film_id, $session);
				}

				/*
					Update Time to show film
				*/
				// TODO: make Exception WrongDateException and separete func or Class(?)
				$sql = "UPDATE time_to_show_films SET begin_date = :begin_date, finish_date = :finish_date
				WHERE film_id = :film_id AND cinema_id = :cinema_id";
				$query = $database->prepare($sql);
				$query->execute(array(
					':film_id' => $parameters->film_id,
					':cinema_id' => $parameters->cinema_id,
					':begin_date' => $parameters->begin_date,
					':finish_date' => $parameters->finish_date
				));

				/*
					Update ticket prices
				*/
				$sql = "UPDATE ticket_prices SET price_from = :price_from, price_to = :price_to
				WHERE film_id = :film_id AND cinema_id = :cinema_id";
				$query = $database->prepare($sql);
				$query->execute(array(
					':film_id' => $parameters->film_id,
					':cinema_id' => $parameters->cinema_id,
					':price_from' => substr($parameters->cost_from, 0, 4),
					':price_to' => substr($parameters->cost_to, 0, 4)
				));

				$res = array('status' => 'success');
				return json_encode($res);

			// } catch (Exception $err) {
				// $obj = array('status' => 'error', 'error' => $err);
				// return json_encode($obj);
			// }

			// if ($query->rowCount() == 1) {
			// 	return true;
			// }

		}


	}

	public static function addFilmShowingInCinema($parameters)
	{
		if ($parameters) {

			$database = DatabaseFactory::getFactory()->getConnection();

			/*
				Check for all parameters
			*/
			$isOnlyOneEmpty = false;
			foreach($parameters as $key => $value) {
			    if ( empty($value) ) {
					$isOnlyOneEmpty = true;
				}
			}

			if ($isOnlyOneEmpty) {
				$res = array('status' => 'expected more arguments');
				return json_encode($res);
			}

			/*
				Add film sessions
			*/
			// second: add new session for curr film_id and cinema_id
			foreach ($parameters->film_sessions as $session) {
				self::addFilmSession($database, $parameters->cinema_id, $parameters->film_id, $session);
			}

			/*
				Add Time to show film
			*/
			// TODO: make Exception WrongDateException and separete func or Class(?)
			$sql = "INSERT INTO time_to_show_films (cinema_id, film_id, begin_date, finish_date) VALUES (:cinema_id, :film_id, :begin_date, :finish_date)";
			$query = $database->prepare($sql);
			$query->execute(array(
				':film_id' => $parameters->film_id,
				':cinema_id' => $parameters->cinema_id,
				':begin_date' => $parameters->begin_date,
				':finish_date' => $parameters->finish_date
			));

			/*
				Update ticket prices
			*/
			$sql = "INSERT INTO ticket_prices (cinema_id, film_id, price_from, price_to) VALUES (:cinema_id, :film_id, :price_from, :price_to)";
			$query = $database->prepare($sql);
			$query->execute(array(
				':film_id' => $parameters->film_id,
				':cinema_id' => $parameters->cinema_id,
				':price_from' => substr($parameters->cost_from, 0, 4),
				':price_to' => substr($parameters->cost_to, 0, 4)
			));


			/*
				Add Film to Cinema
			*/
			$sql = "INSERT INTO link_cinema_film (cinema_id, film_id) VALUES (:cinema_id, :film_id)";
			$query = $database->prepare($sql);
			$query->execute(array(
				':film_id' => $parameters->film_id,
				':cinema_id' => $parameters->cinema_id
			));

			$res = array('status' => 'success');
			return json_encode($res);

		}


	}

	public static function deleteFilmShowingInCinema($parameters)
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		/*
			Delete film sessions
		*/
		$sql = "DELETE FROM film_session WHERE film_id = :film_id AND cinema_id = :cinema_id";
		$query = $database->prepare($sql);
		$query->execute(array(
				':film_id' => $parameters->film_id,
				':cinema_id' => $parameters->cinema_id
		));

		/*
			Delete Time to show films
		*/
		$sql = "DELETE FROM time_to_show_films WHERE film_id = :film_id AND cinema_id = :cinema_id";
		$query = $database->prepare($sql);
		$query->execute(array(
			':film_id' => $parameters->film_id,
			':cinema_id' => $parameters->cinema_id
		));

		/*
			Delete ticket prices
		*/
		$sql = "DELETE FROM ticket_prices WHERE film_id = :film_id AND cinema_id = :cinema_id";
		$query = $database->prepare($sql);
		$query->execute(array(
			':film_id' => $parameters->film_id,
			':cinema_id' => $parameters->cinema_id
		));

		/*
			Delete Film from Cinema
		*/
		$sql = "DELETE FROM link_cinema_film WHERE film_id = :film_id AND cinema_id = :cinema_id";
		$query = $database->prepare($sql);
		$query->execute(array(
			':film_id' => $parameters->film_id,
			':cinema_id' => $parameters->cinema_id
		));

		$res = array('status' => 'success');
		return json_encode($res);
	}

	public static function addFilmSession($database, $cinema_id, $film_id, $session)
	{
		$sql = "INSERT INTO film_session (film_id, cinema_id, film_session) VALUES (:film_id, :cinema_id, :film_session)";
		$query = $database->prepare($sql);
		$query->execute(array(
				':film_id' => $film_id,
				':cinema_id' => $cinema_id,
				':film_session' => $session)
		);
	}

}
