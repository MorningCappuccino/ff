<?php

/*
*	LinkTableModel
*/

class LinkTableModel {

	public static function LinkFilmNomination($film_id, $nomination_id){

		$database = DatabaseFactory::getFactory()->getConnection();
		
		$sql = "INSERT INTO link_film_nomination ($film_id, $nomination_id) VALUES (:film_id, :nomination_id)";
		$query = $database->prepare($sql);
		$query->execute(array(':film_id' => $film_id, ':nomination_id' => $nomination_id));

		if ($query->rowCount() == 1) {
			return true;
		}

		Session::add('feedback_negative', Text::get('FEEDBACK_FILM_NOMINATION_LINK_CREATION_FAILED'));
		return false;

	}

}