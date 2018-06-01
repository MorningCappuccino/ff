<?php

class CinemaModel
{
	/**
	 * Get all cinemas
	 * @return array an array with several objects (the results)
	 */
	public static function getAllCinemas()
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "SELECT * FROM cinemas";
		$query = $database->query($sql);

		// fetchAll() is the PDO method that gets all result rows
		return $query->fetchAll();
	}

	public static function getCinema($cinema_id)
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "SELECT *, id as cinema_id FROM cinemas WHERE id = :cinema_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':cinema_id' => $cinema_id));

		return $query->fetch();
	}

	/*********************
	***** CRUD start *****
	*********************/

	public static function prepareToCreateCinema()
	{

		return [ 'cinema' => (object) [ 'cinema_id' => NULL,
									'cinema_name' => '',
									'address' => '',
									'phone_number' => ''],
				'page' => (object) ['title' => 'Добавление кинотеатра']
		];
	}

	public static function prepareToEditCinema($cinema_id)
	{

		return [ 'cinema' => self::getCinema($cinema_id),
				 'page' => (object) ['title' => 'Редактирование кинотеатра'],
				 'films' => self::getFilmsOfCinema($cinema_id)
				];

	}

	public static function createOrUpdateCinema($cinema_id, $cinema_name, $address, $phone_number)
	{

		$database = DatabaseFactory::getFactory()->getConnection();

		if ($cinema_id == null) {

			// ------->>> CREATE

			$sql = "INSERT INTO cinemas (cinema_name, address, phone_number) VALUES (:cinema_name, :address, :phone_number)";
			$query = $database->prepare($sql);
			$query->execute(array(':cinema_name' => $cinema_name, ':address' => $address, ':phone_number' => $phone_number));
			var_dump($query);

			if ($query->rowCount() == 1) {
				return true;
			}

			Session::add('feedback_negative', Text::get('FEEDBACK_CREATION_FAILED'));
			return false;

		} else {

			// ------->>> UPDATE

			$sql = "UPDATE cinemas SET cinema_name = :cinema_name, address = :address, phone_number = :phone_number WHERE id = :cinema_id";
			$query = $database->prepare($sql);
			$query->execute(array(':cinema_id' => $cinema_id, ':cinema_name' => $cinema_name, ':address' => $address, ':phone_number' => $phone_number));

			if ($query->rowCount() == 1) {
				return true;
			}

			Session::add('feedback_negative', Text::get('FEEDBACK_UPDATE_FAILED'));
			return false;
		}

	}

	public static function deleteCinema($cinema_id)
	{
		if ($cinema_id) {

			$database = DatabaseFactory::getFactory()->getConnection();

			$sql = "DELETE FROM cinemas WHERE id = :cinema_id LIMIT 1";
			$query = $database->prepare($sql);
			$query->execute(array(':cinema_id' => $cinema_id));

			if ($query->rowCount() == 1) {
				return true;
			}

		} else {
			Session::add('feedback_negative', Text::get('FEEDBACK_FILM_DELETION_FAILED'));
			return false;
		}
	}

	/*********************
	***** CRUD end *****
	*********************/

	public static function getFilmsOfCinema($cinema_id)
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "SELECT * FROM films JOIN link_cinema_film link
                ON films.id = link.film_id JOIN cinemas ON link.cinema_id = cinemas.id WHERE cinemas.id = :cinema_id";
		$query = $database->prepare($sql);
		$query->execute(array(':cinema_id' => $cinema_id));

		// select all Films
		$films = $query->fetchAll();

		$xFilms = array();
		foreach ($films as $film) {
			// get one film, search ticket prices for him and write again to Film
			$ticket_price = self::getTicketPrice($film->id, $cinema_id);

			//get dates when film show in cinema
			$filmTime = self::getTimeToShowFilms($film->id, $cinema_id);

			//get film sessions
			$filmSessions = self::getFilmSessions($film->id, $cinema_id);

			$result = (object) array_merge(
				(array) $film,
				(array) $ticket_price,
				(array) $filmTime,
				(array) $filmSessions
			);

			array_push($xFilms, $result);
		}

		return $xFilms;
	}

	public static function getTicketPrice($film_id, $cinema_id)
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "SELECT price_from, price_to FROM ticket_prices tp WHERE tp.film_id = :film_id AND tp.cinema_id = :cinema_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':film_id' => $film_id, ':cinema_id' => $cinema_id));

		return $query->fetchAll()[0];
	}

	/*
		example, from 31.05.2018 to 06.06.2018
		return (object) {begin_date: 31.05.2018, finish_date: 06.06.2018}
	*/
	public static function getTimeToShowFilms($film_id, $cinema_id)
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "SELECT begin_date, finish_date FROM time_to_show_films t WHERE t.film_id = :film_id AND t.cinema_id = :cinema_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':film_id' => $film_id, ':cinema_id' => $cinema_id));

		return $query->fetchAll()[0];
	}

	/*
		example 18:20, 20:30, 21:50
	*/
	public static function getFilmSessions($film_id, $cinema_id)
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "SELECT film_session FROM film_session fs WHERE fs.film_id = :film_id AND fs.cinema_id = :cinema_id";
		$query = $database->prepare($sql);
		$query->execute(array(':film_id' => $film_id, ':cinema_id' => $cinema_id));

		$sessions = (array) $query->fetchAll();

		$xSession = array();
		foreach ($sessions as $session) {
			array_push($xSession, $session->film_session);
		}

		$obj = (object) array('film_sessions' => $xSession);

		return $obj;
	}
}
