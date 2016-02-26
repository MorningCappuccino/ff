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
        // $query = $database;
        // $res = $query->exec($sql);
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
        return $query->fetch();
    }

    /**
     * Set a note (create a new one)
     * @param string $film_name note text that will be created
     * @return bool feedback (was the note created properly ?)
     */
    public static function createFilm($film_id, $film_name)
    {
        // -----------Validate it on JavaScript-----------

        // if (!$film_name || strlen($film_name) == 0) {
        //     Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
        //     return false;
        // }

        $database = DatabaseFactory::getFactory()->getConnection();

        if ($film_id == '') {

            $sql = "INSERT INTO films (film_name, user_id) VALUES (:film_name, :user_id)";
            $query = $database->prepare($sql);
            $query->execute(array(':film_name' => $film_name, ':user_id' => Session::get('user_id')));

            if ($query->rowCount() == 1) {
                return true;
            }

            // default return
            Session::add('feedback_negative', Text::get('FEEDBACK_FILM_CREATION_FAILED'));
            return false;
        } else {
            $sql = "UPDATE films (film_name, user_id) VALUES (:film_name, :user_id)";
            $query = $database->prepare($sql);
            $query->execute(array(':film_name' => $film_name, ':user_id' => Session::get('user_id')));
        }

    }

    /**
     * Update an existing note
     * @param int $note_id id of the specific note
     * @param string $film_name new text of the specific note
     * @return bool feedback (was the update successful ?)
     */
    public static function updateNote($note_id, $film_name)
    {
        if (!$note_id || !$film_name) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE notes SET film_name = :film_name WHERE note_id = :note_id AND user_id = :user_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':note_id' => $note_id, ':film_name' => $film_name, ':user_id' => Session::get('user_id')));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_EDITING_FAILED'));
        return false;
    }

    /**
     * Delete a specific note
     * @param int $note_id id of the note
     * @return bool feedback (was the note deleted properly ?)
     */
    public static function deleteNote($note_id)
    {
        if (!$note_id) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "DELETE FROM notes WHERE note_id = :note_id AND user_id = :user_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':note_id' => $note_id, ':user_id' => Session::get('user_id')));

        if ($query->rowCount() == 1) {
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_DELETION_FAILED'));
        return false;
    }
}
