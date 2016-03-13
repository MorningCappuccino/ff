<?php

/**
 * EventController
 */
class EventController extends Controller
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
     * Gets all events.
     */
    public function index()
    {
        $this->View->render('madmin/events/index', array(
            'events' => EventModel::getAllEvents()
        ));
    }

    /**
     * This method controls what happens when you move to /dashboard/create in your app.
     * Creates a new nomination. This is usually the target of form submit actions.
     * POST request.
     */
    public function create($event_id = null)
    {
        $this->View->render('madmin/events/create-edit', array(
            'data' => EventModel::prepareToCreateOrEditEvent($event_id)
        ));
    }
    
    /**
     * This method controls what happens when you move to /nomination/edit(/XX) in your app.
     * Shows the current content of the nomination and an editing form.
     * @param $nomination_id int id of the nomination
     */
    public function edit($event_id)
    {
        $this->View->render('madmin/events/create-edit', array(
            'data' => EventModel::prepareToCreateOrEditEvent($event_id)
        ));
    }

    /**
     * This method controls what happens when you move to /nomination/editSave in your app.
     * Edits a nomination (performs the editing after form submit).
     * POST request.
     */
    public function save()
    {
    	// var_dump($_POST);
    	// var_dump($_FILES);
        EventModel::createOrUpdateEvent(Request::post('event_id'), Request::post('fest_type_id'),
                                                                Request::post('event_year'),
                                                                // $_FILES['uploadFile']['name'][0],
                                                                Request::post('begin_date'),
                                                                Request::post('finish_date')
                                                                );
        Redirect::to('event');
    }

    /**
     * This method controls what happens when you move to /nomination/delete(/XX) in your app.
     * Deletes a nomination. In a real application a deletion via GET/URL is not recommended, but for demo purposes it's
     * totally okay.
     * @param int $nomination_id id of the nomination
     */
    public function delete($nomination_id)
    {
        EventModel::delete($nomination_id);
        Redirect::to('nomination');
    }

/**
 * *************** End CEUD
 */

    public function allfestivals()
    {
        $this->View->render('allfestivals/index', array(
            'events' => EventModel::getAllEvents()
        ));
    }

    public function details($event_id)
    {
        $this->View->render('allfestivals/details', array(
            'event' => (object) EventModel::getDetails($event_id)
        ));
    }
}