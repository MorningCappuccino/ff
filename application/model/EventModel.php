<?php

/**
 * EventModel
 */
class EventModel
{
	/**
	 * Get all events
	 * @return array an array with several objects (the results)
	 */
	public static function getAllEvents()
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "SELECT * FROM view_events";
		$query = $database->query($sql);

		// fetchAll() is the PDO method that gets all result rows
		return $query->fetchAll();
	}

	/**
	 * Get all festival types
	 * @return array an array with several objects (the results)
	 */
	public static function getAllFestivalTypes()
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "SELECT * FROM fest_type";
		$query = $database->query($sql);

		// fetchAll() is the PDO method that gets all result rows
		return $query->fetchAll();
	}

	/**
	 * Get a single note
	 * @param int $note_id id of the specific note
	 * @return object a single object (the result)
	 */
	public static function getEvent($event_id)
	{
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "SELECT *, events.id as event_id, fest_type.name as fest_type_name FROM events JOIN fest_type ON fest_type.id = events.fest_type_id WHERE events.id = :event_id";
		$query = $database->prepare($sql);
		$query->execute(array(':event_id' => $event_id));

		// fetch() is the PDO method that gets a single result
		return $query->fetch();
	}

	public static function prepareToCreateOrEditEvent($event_id)
	{
		if($event_id){

			return [ 'event' => self::getEvent($event_id),
			'fest_types' => EventModel::getAllFestivalTypes(),
			'page' => (object) ['title' => 'Редактирование события'],
			];

		} else {

			return [ 'event' => (object) [ 'event_id' => NULL,
																		'year' => NULL,
																		'begin_date' => NULL,
																		'finish_date' => NULL
																		],
			'fest_types' => EventModel::getAllFestivalTypes(),
			'page' => (object) ['title' => 'Добавление события'],
			];
		}

	}



	/**
	 * Set a note (create a new one)
	 * @param string $film_name note text that will be created
	 * @return bool feedback (was the note created properly ?)
	 */
	public static function createOrUpdateEvent($event_id, $fest_type_id, $event_year, $begin_date, $finish_date)
	{

		$database = DatabaseFactory::getFactory()->getConnection();

		if ($event_id == null) {

			$img_link = ImageModel::createImage();
			$event_status = EventModel::SetEventStatus($begin_date, $finish_date);

			$sql = "INSERT INTO events (fest_type_id, year, img_link, begin_date, finish_date, status_id) VALUES (:fest_type_id, :event_year, :img_link, :begin_date, :finish_date, :status_id)";
			$query = $database->prepare($sql);
			$query->execute(array(':fest_type_id' => $fest_type_id, ':event_year' => $event_year, ':img_link' => $img_link, ':begin_date' => $begin_date, ':finish_date' => $finish_date, ':status_id' => $event_status));

			if ($query->rowCount() == 1) {
				return true;
			}

			Session::add('feedback_negative', Text::get('FEEDBACK_CREATION_FAILED'));
			return false;

		} else {

			//TODO rebuild update image system
			$img_link = ImageModel::createImage();//return 'hash_img' if new image upload and 'false' if image not upload 

			$event_status = EventModel::SetEventStatus($begin_date, $finish_date);


			//People Award
			//Right now I selecte Film-winner on update Festival action
			//may be it will be better something else, for example, cron-proccess or some button
			if ($event_status == 3){
				$film_id = FilmModel::getFilmWonPeopleAward($event_id);

				$sql00 = "SELECT event_id FROM people_award WHERE event_id = :event_id";
				$query = $database->prepare($sql00);
				$query->execute(array(':event_id' => $event_id));

				if ($query->rowCount() != 1) {

				$sql0 = "INSERT INTO people_award (event_id, film_id) VALUES (:event_id, :film_id)";
				$query = $database->prepare($sql0);
				$query->execute(array(':event_id' => $event_id, ':film_id' => $film_id));

			}

			}
			//end People Award


			if($img_link != 'file didnt upload'){
				$sql = "UPDATE events SET fest_type_id = :fest_type_id, year = :year, img_link = :img_link, begin_date = :begin_date, finish_date = :finish_date, status_id = :status_id WHERE id = :event_id";
				$query = $database->prepare($sql);
				$query->execute(array(':fest_type_id' => $fest_type_id, ':year' => $event_year, ':img_link' => $img_link, ':begin_date' => $begin_date, ':finish_date' => $finish_date, ':status_id' => $event_status, ':event_id' => $event_id));
			} else {
				$sql = "UPDATE events SET fest_type_id = :fest_type_id, year = :year, begin_date = :begin_date, finish_date = :finish_date, status_id = :status_id WHERE id = :event_id";
				$query = $database->prepare($sql);
				$query->execute(array(':fest_type_id' => $fest_type_id, ':year' => $event_year, ':begin_date' => $begin_date, ':finish_date' => $finish_date, ':status_id' => $event_status, ':event_id' => $event_id));

				//cause if saved previosly information $query-rowCount() == 0
				return true;
			}

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
	public static function delete($event_id)
	{
		if (!$event_id) {
            goto fail;
		}

  		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = "DELETE FROM events WHERE id = :event_id LIMIT 1";
		$query = $database->prepare($sql);
		$query->execute(array(':event_id' => $event_id));

		if ($query->rowCount() == 1) {
			return true;
		}

        fail:
		Session::add('feedback_negative', Text::get('FEEDBACK_FILM_DELETION_FAILED'));
		return false;
	}

///////////////////////////////////// CEUD end ////////////////////////////////////////

    public static function getDetails($event_id)
    {

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM view_events WHERE id = :event_id";
        $query = $database->prepare($sql);
        $query->execute(array(':event_id' => $event_id));

        return ['fest_info' => $query->fetch(),
        				'films' => EventModel::getAllFilmsByEventId($event_id),
        				'people_award' => EventModel::getFilmInEventWonPeopleAward($event_id)
        				];

    }

    public static function getAllFilmsByEventId($event_id)
    {
    
        $database = DatabaseFactory::getFactory()->getConnection();
    
        $sql = "SELECT * FROM films WHERE event_id = :event_id";
        $query = $database->prepare($sql);
        $query->execute(array(':event_id' => $event_id));
    
        return $query->fetchAll();
    
    }

    public static function getFilmInEventWonPeopleAward($event_id)
    {
    
        $database = DatabaseFactory::getFactory()->getConnection();
    
        $sql = "SELECT film_id FROM people_award WHERE event_id = :event_id";
        $query = $database->prepare($sql);
        $query->execute(array(':event_id' => $event_id));
    
        return FilmModel::getFilm($query->fetch()->film_id);
    
    }

/*=======================================================
----------------EventModel's Helpers---------------------
=======================================================*/

    public static function setEventStatus($begin_date, $finish_date)
    {
    	$cur_date = getDate()[0];
    	$begin = strToTime($begin_date);
    	$finish = strToTime($finish_date);
    	switch ($cur_date)
    	{
    		case ($finish > $cur_date && $cur_date > $begin): return 1;
    		case ($cur_date < $begin): return 2;
    		case ($cur_date > $finish): return 3;
    	}
    }

    public static function getCSSClassEqualsStatusName($status_name)
    {
    	switch ($status_name)
    	{
    		case ($status_name == 'Мотор'): return 'alert-success';
    		case ($status_name == 'В подготовке'): return 'alert-warning';
    		case ($status_name == 'Завершён'): return 'alert-danger';
    	}
    }
}