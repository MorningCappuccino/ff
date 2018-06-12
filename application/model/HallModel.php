<?php

class HallModel
{
    private static $num_seats = 48;

    private static $last_mysql_id = null;

    public static function addHallAndSeats($cinema_id, $film_id, $session_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO halls (cinema_id, film_id, session_id) VALUES (:cinema_id, :film_id, :session_id)";
        $query = $database->prepare($sql);
        $query->execute(array(
            ':cinema_id' => $cinema_id,
            ':film_id' => $film_id,
            ':session_id' => $session_id
        ));

        if ($query->rowCount() != 1) {
            return false;
        }

        $last_hall_id = FilmAjaxModel::getLastIdFromTable('halls');

        // Add seats 6 seats 8 rows = 48 seats
        for ($i = 1; $i <= self::$num_seats; $i++) {
            $sql = "INSERT INTO seats (hall_id, seat_num) VALUES (:hall_id, :seat_num)";
            $query = $database->prepare($sql);
            $query->execute(array(
                ':hall_id' => $last_hall_id,
                ':seat_num' => $i
            ));
        }

        return true;
    }
}
