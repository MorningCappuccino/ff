<?php

class CinemaController extends Controller
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

    /*********************
    ***** CRUD start *****
    *********************/

    public function create()
    {
        $this->View->render('madmin/cinemas/create-edit', array(
            'data' => CinemaModel::prepareToCreateCinema()
            ));
    }

    /**
     * This method controls what happens when you move to /note/edit(/XX) in your app.
     * Shows the current content of the note and an editing form.
     * @param $note_id int id of the note
     */
    public function edit($cinema_id)
    {
        $this->View->render('madmin/cinemas/create-edit', array(
            'data' => CinemaModel::prepareToEditCinema($cinema_id)
        ));
    }

    /**
     * This method controls what happens when you move to /note/editSave in your app.
     * Edits a note (performs the editing after form submit).
     * POST request.
     */
    public function save()
    {
        CinemaModel::createOrUpdateCinema(
            Request::post('cinema_id'),
            Request::post('cinema_name'),
            Request::post('address'),
            Request::post('phone_number')
        );

        Redirect::to('cinema/index');
    }

    /**
     * @param int $note_id id of the note
     */
    public function delete($cinema_id)
    {
        CinemaModel::deleteCinema($cinema_id);
        Redirect::to('cinema/index');
    }

    /*********************
    ***** CRUD end *****
    *********************/

    public function index()
    {
        $this->View->render('madmin/cinemas/index', array(
            'cinemas' => CinemaModel::getAllCinemas()
        ));
    }

    public function allCinemas()
    {
        $this->View->render('cinema/index', array(
            'cinemas' => CinemaModel::getAllCinemas()
        ));
    }

    public function details($cinema_id)
    {
        //today
        $date = new DateTime(date("Y-m-d"));
        $date = $date->format('Y-m-d');

        $this->View->render('cinema/details', array(
            'data' => CinemaModel::getFilmsOfCinemaByDay($cinema_id, $date)
        ));
    }

}
