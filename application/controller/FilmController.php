<?php

class FilmController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();

        // VERY IMPORTANT: All controllers/areas that should only be usable by logged-in users
        // need this line! Otherwise not-logged in users could do actions. If all of your pages should only
        // be usable by logged-in users: Put this line into libs/Controller->__construct
        // Auth::checkAuthentication();
    }

    public function create()
    {
        $this->View->render('madmin/films/create-edit', array(
            'data' => FilmModel::prepareToCreateFilm()
            ));
    }

    /**
     * This method controls what happens when you move to /note/edit(/XX) in your app.
     * Shows the current content of the note and an editing form.
     * @param $note_id int id of the note
     */
    public function edit($film_id)
    {
        $this->View->render('madmin/films/create-edit', array(
            'data' => FilmModel::prepareToEditFilm($film_id)
        ));
    }

    /**
     * This method controls what happens when you move to /note/editSave in your app.
     * Edits a note (performs the editing after form submit).
     * POST request.
     */
    public function save()
    {
        FilmModel::createOrUpdateFilm(Request::post('film_id'), Request::post('category_id'),
                                                                Request::post('film_name'),
                                                                Request::post('descr'),
                                                                Request::post('event_id'),
                                                                Request::post('nomination_id'),
                                                                Request::post('age_limit_id'),
                                                                Request::post('duration'),
                                                                Request::post('link_on_trailer')
                                                                );
        Redirect::to('madmin/films');
    }

    /**
     * @param int $note_id id of the note
     */
    public function delete($film_id)
    {
        FilmModel::deleteFilm($film_id);
        Redirect::to('madmin/films');
    }
// CEUD end


    public function allfilms()
    {
        $this->View->render('allfilms/index', [
            'data' => array( 'films' => FilmModel::getAllFilms() )
            ]);
    }

    public function details($film_id)
    {
        $this->View->render('allfilms/details', [
            'data' => FilmModel::getDetails($film_id)
            ]);
    }


    public static function rateFilm($film_id, $score)
    {
        FilmModel::rateFilm($film_id, $score);
    }

}
