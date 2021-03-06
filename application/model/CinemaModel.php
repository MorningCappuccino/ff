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

	public static function getFilmsOfCinemaByDay($cinema_id, $date)
	{
		return [ 'cinema' => self::getCinema($cinema_id),
				 'films' => self::getFilmsOfCinemaByOneDay($cinema_id, $date)
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
			$ticket_price = self::getTicketPrice($film->film_id, $cinema_id);

			//get dates when film show in cinema
			$filmTime = self::getTimeToShowFilms($film->film_id, $cinema_id);

			//get film sessions
			$filmSessions = self::getFilmSessions($film->film_id, $cinema_id);

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

	public static function getFilmsOfCinemaByOneDay($cinema_id, $date)
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		// var_dump($date);

		$sql = "SELECT DISTINCT link.film_id, film_name, score, category_id, price_from, price_to, begin_date, finish_date FROM films
				JOIN link_cinema_film link ON films.id = link.film_id
				JOIN cinemas ON link.cinema_id = cinemas.id
				JOIN ticket_prices tp ON tp.film_id = films.id
				JOIN time_to_show_films ttsf ON ttsf.film_id = films.id
				WHERE cinemas.id = 1
				AND ttsf.begin_date < :curr_date
				AND ttsf.finish_date > :curr_date
				";
		$query = $database->prepare($sql);
		$query->execute(array(':cinema_id' => $cinema_id, ':curr_date' => $date));

		// select all Films
		$films = $query->fetchAll();

		$xFilms = array();
		foreach ($films as $film) {
			//get film sessions
			$filmSessions = self::getFilmSessions($film->film_id, $cinema_id);

			$result = (object) array_merge(
				(array) $film,
				(array) $filmSessions
			);

			array_push($xFilms, $result);
		}

		return $xFilms;
	}

	public static function getSeatsOfHall($parameters)
	{
		if ( !self::isAllParametersHaveValue($parameters) ) {
			return array('status' => 'expected more arguments');
		}

		$p = $parameters;

		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "SELECT halls.id as hall_id, seats.id as seat_id, seat_num, user FROM halls
				JOIN seats ON halls.id = seats.hall_id
				WHERE cinema_id = :cinema_id AND film_id = :film_id AND session_id = :session_id";
		$query = $database->prepare($sql);
		$query->execute(array(':cinema_id' => $p->cinema_id, ':film_id' => $p->film_id, ':session_id' => $p->session_id));

		$seats = $query->fetchAll();
		return $seats;
	}

	public static function paySuccessfull($parameters)
	{

		if ( !self::isAllParametersHaveValue($parameters) ) {
			return array('status' => 'expected more arguments');
		}

		$database = DatabaseFactory::getFactory()->getConnection();

		$countSuccessRow = 0;

		foreach ($parameters->seat_ids as $seat_id) {
			$sql = "UPDATE seats SET user = :user_id, order_number = :order_number WHERE id = :seat_id";
			$query = $database->prepare($sql);
			$query->execute(array(':user_id' => Session::get('user_id'), ':seat_id' => $seat_id, ':order_number' => self::randHash(6)));

			if ($query->rowCount() == 1) {
				$countSuccessRow++;
			}
		}

		if ( $countSuccessRow == count($parameters->seat_ids) ) {
			return array('status' => 'success');
		}

		return array('status' => 'error');

	}

	/*********************
	***** Helper Func ****
	*********************/

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

		$sql = "SELECT id, film_session FROM film_session fs WHERE fs.film_id = :film_id AND fs.cinema_id = :cinema_id";
		$query = $database->prepare($sql);
		$query->execute(array(':film_id' => $film_id, ':cinema_id' => $cinema_id));

		$sessions = (array) $query->fetchAll();

		$xSession = array();
		foreach ($sessions as $session) {
			$xSession[$session->id] = $session->film_session;
		}

		$obj = (object) array('film_sessions' => $xSession);

		return $obj;
	}

	public static function isAllParametersHaveValue($params)
	{
		$isOnlyOneEmpty = false;
		foreach($params as $key => $value) {
			if ( empty($value) ) {
				$isOnlyOneEmpty = true;
			}
		}

		if ($isOnlyOneEmpty) {
			return false;
		}

		return true;
	}

	public static function randHash($len=32)
	{
		// return substr(md5(openssl_random_pseudo_bytes(20)),-$len);
		return substr(uniqid(), -6);
	}
}
