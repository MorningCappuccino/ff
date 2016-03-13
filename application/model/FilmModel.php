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

		//Делал для редктирования фильма, нужно подумать над универсальностью
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "SELECT *, id as film_id FROM films WHERE id = :film_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':film_id' => $film_id));

		// fetch() is the PDO method that gets a single result
		return $query->fetch();
	}

	public static function prepareToCreateFilm()
	{

		return [ 'film' => (object) [ 'film_id' => NULL,
																	'film_name' => '',
																	'category_id' => NULL,
																	'descr' => '',
																	'event_id' => NULL],
				'categories' => CategoryModel::getAllcategories(),
				'page' => (object) ['title' => 'Добавление фильма'],
				'nominations' => NominationModel::getAllNominations(),
				'events' => EventModel::getAllEvents()
		];
	}

	public static function prepareToEditFilm($film_id)
	{

		return [ 'film' => self::getFilm($film_id),
				 'categories' => CategoryModel::getAllcategories(),
				 'page' => (object) ['title' => 'Редактирование фильма'],
				 'nominations' => NominationModel::getAllNominations(),
				 'events' => EventModel::getAllEvents()
				];

	}

	/**
	 * Set a note (create a new one)
	 * @param string $film_name note text that will be created
	 * @return bool feedback (was the note created properly ?)
	 */
	public static function createOrUpdateFilm($film_id, $category_id, $film_name, $descr, $event_id, $nomination_id)
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

			$img_link = ImageModel::createImage();

			$sql = "INSERT INTO films (film_name, category_id, img_link, descr, event_id, user_id) VALUES (:film_name, :category_id, :img_link, :descr, :event_id, :user_id)";
			$query = $database->prepare($sql);
			$query->execute(array(':film_name' => $film_name, ':category_id' => $category_id, ':img_link' => $img_link, ':descr' => $descr, ':event_id' => $event_id, ':user_id' => Session::get('user_id')));

			if ($query->rowCount() == 1) {
				return true;
			}

			LinkTableModel::LinkFilmNomination($film_id, $nomination_id);

			Session::add('feedback_negative', Text::get('FEEDBACK_FILM_CREATION_FAILED'));
			return false;

		} else {

			//TODO bad sectoin again (like Event model)
			$img_link = ImageModel::createImage();

			if($img_link == 'file didnt upload') {
				$sql = "UPDATE films SET film_name = :film_name, category_id = :category_id, descr = :descr, event_id = :event_id WHERE id = :film_id";
				$query = $database->prepare($sql);
				$query->execute(array(':film_id' => $film_id, ':film_name' => $film_name, ':category_id' => $category_id, ':descr' => $descr, ':event_id' => $event_id));
			} else {
				$sql = "UPDATE films SET film_name = :film_name, category_id = :category_id, img_link = :img_link, descr = :descr, event_id = :event_id WHERE id = :film_id";
				$query = $database->prepare($sql);
				$query->execute(array(':film_id' => $film_id, ':film_name' => $film_name, ':category_id' => $category_id, ':img_link' => $img_link, ':descr' => $descr, ':event_id' => $event_id));
			}

			LinkTableModel::LinkFilmNomination($film_id, $nomination_id);

			if ($query->rowCount() == 1) {
				return true;
			}


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
            goto fail;
		}

  		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "DELETE FROM films WHERE id = :film_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':film_id' => $film_id));

		if ($query->rowCount() == 1) {
			return true;
		}

        fail:
		Session::add('feedback_negative', Text::get('FEEDBACK_FILM_DELETION_FAILED'));
		return false;
	}

// CEUD end

    public static function getDetails($film_id)
    {

        // $database = DatabaseFactory::getFactory()->getConnection();

        //get only film name, img, descr
    		$film_info = self::getFilm($film_id);

        //get only all film nominations
        $film_nominations = NominationModel::getNominationsByFilmId($film_id);

        //get score of user film
        $score_of_user = UserModel::getFilmScoreByUserId(Session::get('user_id'), $film_id);

        //TODO rewrite avg_score on get avg from film_info
        $avg_score = FilmModel::getAVGScoreByFilmId($film_id);

        return  ['film_info' => $film_info,
        				 'user' => (object)['film_score' => $score_of_user],
        				 'nominations' => $film_nominations,
        				 'avg_score' => $avg_score
        					];

    }

    public static function getAVGScoreByFilmId($film_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT COUNT(score) as count_score, ROUND(AVG(score),1) as avg_score FROM link_user_film_score WHERE film_id = :film_id";
        $query = $database->prepare($sql);
        $query->execute(array(':film_id' => $film_id));

        return $query->fetch();
    }
}
