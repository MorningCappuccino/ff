<?php

class CategoryModel {
	public static function getAllCategories()
	{
		$database = DatabaseFactory::getFactory()->getConnection();

    $sql = "SELECT id, cat_name FROM film_category";
    $query = $database->prepare($sql);
    $query->execute();

    $all_categories = array();

    foreach ($query->fetchAll() as $category) {

        array_walk_recursive($category, 'Filter::XSSFilter');

        $all_categories[$category->id] = new stdClass();
        $all_categories[$category->id]->category_id = $category->id;
        $all_categories[$category->id]->category_name = $category->cat_name;
    }

    return $all_categories;
	}

    public static function getCategory($category_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT id as category_id, cat_name as category_name FROM film_category WHERE id = :category_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':category_id' => $category_id));

        // fetch() is the PDO method that gets a single result
        return $query->fetch();
    }

    public static function updateCategory($category_id, $category_name)
    {
        if (!$category_id || !$category_name) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE film_category SET cat_name = :category_name WHERE id = :category_id LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':category_id' => $category_id, ':category_name' => $category_name));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_EDITING_FAILED'));
        return false;
    }

    public static function createCategory($category_name)
    {
        if (!$category_name || strlen($category_name) == 0) {
            Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO film_category (cat_name) VALUES (?)";
        $query = $database->prepare($sql);
        $query->execute(array($category_name));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
        return false;
    }

    public static function delete($category_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "DELETE FROM film_category WHERE id = ?";
        $query = $database->prepare($sql);
        $query->execute(array($category_id));

        if ($query->rowCount() == 1) {
            return true;
        }

        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
        return false;
    }

}


