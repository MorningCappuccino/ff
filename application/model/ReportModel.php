<?php

class ReportModel
{
    public static function getAllStripeTransaction()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT cinema_name, film_name, film_session, seat_num, order_number, order_date, stripe_order_id, user_name, users.user_id FROM seats
                  JOIN halls h ON h.id = seats.hall_id
                  JOIN films f ON h.film_id = f.id
                  JOIN film_session fs ON fs.id = h.session_id
                  JOIN cinemas ON cinemas.id = h.cinema_id
                  JOIN users ON users.user_id = seats.user
                WHERE stripe_order_id IS NOT NULL";
		$query = $database->prepare($sql);
		$query->execute();

		$res = $query->fetchAll();
        return $res;
    }
}
