<?php

class NominationModel
{
    /**
     *
     * @return array an array with several objects (the results)
     */
    public static function getAllNominations()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT nomination_id, nomination_name FROM nominations";
        $query = $database->query($sql);

        return $query->fetchAll();
    }

    /**
     * Get a single note
     * @param int $nomination_id id of the specific note
     * @return object a single object (the result)
     */
    public static function getNomination($nomination_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT nomination_id, nomination_name FROM nominations WHERE nomination_id = :nomination_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':nomination_id' => $nomination_id));

        return $query->fetch();
    }

    /**
     * Set a note (create a new one)
     * @param string $nomination_name note text that will be created
     * @return bool feedback (was the note created properly ?)
     */
    public static function create($nomination_name)
    {
        if (!$nomination_name || strlen($nomination_name)==0) {
            Session::add('feedback_negative', Text::get('FEEDBACK_CREATION_FAILED'));
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO nominations (nomination_name) VALUES (:nomination_name)";
        $query = $database->prepare($sql);
        $query->execute(array(':nomination_name' => $nomination_name));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_CREATION_FAILED'));
        return false;
    }

    /**
     * Update an existing note
     * @param int $nomination_id id of the specific note
     * @param string $nomination_name new text of the specific note
     * @return bool feedback (was the update successful ?)
     */
    public static function update($nomination_id, $nomination_name)
    {

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE nominations SET nomination_name = :nomination_name WHERE nomination_id = :nomination_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':nomination_id' => $nomination_id, ':nomination_name' => $nomination_name));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_EDITING_FAILED'));
        return false;
    }

    /**
     * Delete a specific note
     * @param int $nomination_id id of the note
     * @return bool feedback (was the note deleted properly ?)
     */
    public static function delete($nomination_id)
    {
        if (!$nomination_id) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "DELETE FROM nominations WHERE nomination_id = :nomination_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':nomination_id' => $nomination_id));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_DELETION_FAILED'));
        return false;
    }


    public static function getNominationsByFilmId($film_id)
    {

        $database = DatabaseFactory::getFactory()->getConnection();

        //get only nomination of film
        $sql = "SELECT nomination_name FROM films JOIN link_film_nomination link
                ON films.id = link.film_id JOIN nominations ON link.nomination_id = nominations.nomination_id WHERE films.id = :film_id";
        $query = $database->prepare($sql);
        $query->execute(array(':film_id' => $film_id));


        return $query->fetchAll();

    }
}
