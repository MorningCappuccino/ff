<?php

/**
 * FilmModel
 */
class FilmModel
{
	/**
	 * Get all films
	 * @return array an array with several objects (the results)
	 */
	public static function getAllFilms()
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "SELECT * FROM films";
		$query = $database->query($sql);

		// fetchAll() is the PDO method that gets all result rows
		return $query->fetchAll();
	}

	/**
	 * Get a single note
	 * @param int $note_id id of the specific note
	 * @return object a single object (the result)
	 */
	public static function getFilm($film_id)
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "SELECT *, id as film_id FROM films WHERE id = :film_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':film_id' => $film_id));

		// fetch() is the PDO method that gets a single result
		return [ 'film' => $query->fetch(),
				 'categories' => CategoryModel::getAllcategories(),
				 'page' => (object) ['title' => 'Редактирование фильма'],
				 'nominations' => NominationModel::getAllNominations()
				];
	}

	public static function prepareToCreateFilm()
	{

		return [ 'film' => (object) [ 'film_id' => NULL,
										'film_name' => '',
										'category_id' => NULL],
				'categories' => CategoryModel::getAllcategories(),
				'page' => (object) ['title' => 'Добавление фильма'],
				'nominations' => NominationModel::getAllNominations()
		];
	}

	/**
	 * Set a note (create a new one)
	 * @param string $film_name note text that will be created
	 * @return bool feedback (was the note created properly ?)
	 */
	public static function createOrUpdateFilm($film_id, $category_id, $film_name, $nomination_id)
	{
		// -----------Validate it on JavaScript-----------

		// if (!$film_name || strlen($film_name) == 0) {
		//     Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
		//     return false;
		// }

		$database = DatabaseFactory::getFactory()->getConnection();

		$arr = [0 => $film_name];
		array_walk($arr, 'Filter::XSSFilter');
		$film_name = $arr[0];
		// $film_name = Filter::XSSFilter($film_name);

		if ($film_id == null) {

			$sql = "INSERT INTO films (film_name, user_id) VALUES (:film_name, :user_id)";
			$query = $database->prepare($sql);
			$query->execute(array(':film_name' => $film_name, ':user_id' => Session::get('user_id')));

			if ($query->rowCount() == 1) {
				return true;
			}
			
			LinkTableModel::LinkFilmNomination($film_id, $nomination_id);

			Session::add('feedback_negative', Text::get('FEEDBACK_FILM_CREATION_FAILED'));
			return false;
		} else {

			$sql = "UPDATE films SET film_name = :film_name, category_id = :category_id WHERE id = :film_id";
			$query = $database->prepare($sql);
			$query->execute(array(':film_id' => $film_id, ':film_name' => $film_name, ':category_id' => $category_id));

			if ($query->rowCount() == 1) {
				return true;
			}

			// LinkTableModel::LinkFilmNomination($film_id, $nomination_id);

			Session::add('feedback_negative', Text::get('FEEDBACK_FILM_UPDATE_FAILED'));
			return false;
		}

	}

	/**
	 * Delete a specific note
	 * @param int $note_id id of the note
	 * @return bool feedback (was the note deleted properly ?)
	 */
	public static function deleteFilm($film_id)
	{
		if (!$film_id) {
			return false;
		}

		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "DELETE FROM films WHERE id = :film_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':film_id' => $film_id));

		if ($query->rowCount() == 1) {
			return true;
		}

		Session::add('feedback_negative', Text::get('FEEDBACK_FILM_DELETION_FAILED'));
		return false;
	}
}
