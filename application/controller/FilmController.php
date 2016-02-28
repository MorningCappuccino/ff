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
        Auth::checkAuthentication();
    }


    // public function create()
    // {
    //     $this->View->render('madmin/films/create-edit', array(
    //         'data' => array('film' => (object)['film_id' => null,
    //                                             'film_name' => ''])
    //         ));
    // }

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
    public function edit($p)
    {
        $this->View->render('madmin/films/create-edit', array(
            'data' => FilmModel::getFilm($p)
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
                                                                Request::post('nomination_id')
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
}
