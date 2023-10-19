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
		$query->execute(array(':film_id' => $parameters->film_id,
							':user_id' => Session::get('user_id'),
							':score' => $parameters->user_score
						));

		if ($query->rowCount() == 1) {
			return array('status' => 'success');
		}

		fail:
		Session::add('feedback_negative', Text::get('FEEDBACK_CREATION_FAILED'));
		return false;
	}

	public static function editFilmShowingInCinema($parameters)
	{
		if ($parameters) {

			$cinema_id = $parameters->cinema_id;
			$film_id = $parameters->film_id;

			$database = DatabaseFactory::getFactory()->getConnection();

			// try {

				/*
					Add film sessions
				*/
				// first: delete all session for curr film_id and cinema_id
				// $sql = "DELETE FROM film_session WHERE film_id = :film_id AND cinema_id = :cinema_id";
				// $query = $database->prepare($sql);
				// $query->execute(array(':film_id' => $parameters->film_id, ':cinema_id' => $parameters->cinema_id));

				// second: add new session for curr film_id and cinema_id



				foreach ($parameters->film_sessions as $session) {
					//select session from DB - check if exist
					$isSessionExist = self::selectFilmSession($database, $cinema_id, $film_id, $session);

					if ($isSessionExist) {
						continue;
					}

					$lastAddedSessionID = self::addFilmSession($database, $parameters->cinema_id, $parameters->film_id, $session);

					HallModel::addHallAndSeats($cinema_id, $film_id, $lastAddedSessionID);
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
			if (!CinemaModel::isAllParametersHaveValue($parameters)) {
				$res = array('status' => 'expected more arguments');
				return json_encode($res);
			}

			/*
				Add film sessions
			*/
			// second: add new session for curr film_id and cinema_id
			foreach ($parameters->film_sessions as $session) {
				$addedSessionID = self::addFilmSession($database, $parameters->cinema_id, $parameters->film_id, $session);

				HallModel::addHallAndSeats($parameters->cinema_id, $parameters->film_id, $addedSessionID);
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

	/*
		return sessionID
	*/
	public static function addFilmSession($database, $cinema_id, $film_id, $session)
	{
		$sql = "INSERT INTO film_session (film_id, cinema_id, film_session) VALUES (:film_id, :cinema_id, :film_session); SELECT LAST_INSERT_ID();";
		$query = $database->prepare($sql);
		$query->execute(array(
				':film_id' => $film_id,
				':cinema_id' => $cinema_id,
				':film_session' => $session)
		);

		if ($query->rowCount() != 1) {
			return false;
		}

		// get last id

		$sql = "SELECT MAX(id) as id FROM film_session";
		$query = $database->prepare($sql);
		$query->execute();

		$addedID = $query->fetch()->id;
		return $addedID;

	}

	public static function getLastIdFromTable($table)
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "SELECT MAX(id) as id FROM " . $table;
		$query = $database->prepare($sql);
		$query->execute();

		return $query->fetch()->id;
	}

	/*
		return true/false
	*/
	public static function selectFilmSession($database, $cinema_id, $film_id, $session)
	{
		$sql = "SELECT * FROM film_session WHERE cinema_id = :cinema_id AND film_id = :film_id AND film_session = :film_session";
		$query = $database->prepare($sql);
		$query->execute(array(
				':film_id' => $film_id,
				':cinema_id' => $cinema_id,
				':film_session' => $session)
		);

		return ($query->rowCount() == 1) ? true : false;
	}

	/*
		return true/false
	*/
	public static function deleteSession($parameters)
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "DELETE FROM film_session WHERE id = :id";
		$query = $database->prepare($sql);
		$query->execute(array(
				':id' => $parameters->session_id
			)
		);

		if ( $query->rowCount() == 1 ) {
			return self::statusSuccess();
		}

	}

	public static function statusSuccess()
	{
		$res = array('status' => 'success');
		return json_encode($res);
	}

}
