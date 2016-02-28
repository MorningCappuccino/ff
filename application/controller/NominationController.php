<?php

/**
 * 
 */
class NominationController extends Controller
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

    /**
     * 
     * Gets all nomination.
     */
    public function index()
    {
        $this->View->render('madmin/nominations/index', array(
            'nominations' => NominationModel::getAllNominations()
        ));
    }

    /**
     * This method controls what happens when you move to /dashboard/create in your app.
     * Creates a new nomination. This is usually the target of form submit actions.
     * POST request.
     */
    public function create()
    {
        NominationModel::create(Request::post('nomination_name'));
        Redirect::to('nomination');
    }
    
    /**
     * This method controls what happens when you move to /nomination/edit(/XX) in your app.
     * Shows the current content of the nomination and an editing form.
     * @param $nomination_id int id of the nomination
     */
    public function edit($nomination_id)
    {
        $this->View->render('madmin/nominations/edit', array(
            'nomination' => NominationModel::getNomination($nomination_id)
        ));
    }

    /**
     * This method controls what happens when you move to /nomination/editSave in your app.
     * Edits a nomination (performs the editing after form submit).
     * POST request.
     */
    public function save()
    {
        NominationModel::update(Request::post('nomination_id'), Request::post('nomination_name'));
        Redirect::to('nomination');
    }

    /**
     * This method controls what happens when you move to /nomination/delete(/XX) in your app.
     * Deletes a nomination. In a real application a deletion via GET/URL is not recommended, but for demo purposes it's
     * totally okay.
     * @param int $nomination_id id of the nomination
     */
    public function delete($nomination_id)
    {
        NominationModel::delete($nomination_id);
        Redirect::to('nomination');
    }
}
