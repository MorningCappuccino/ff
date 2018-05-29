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
				 'page' => (object) ['title' => 'Редактирование кинотеатра']
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
}
