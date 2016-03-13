<?php

class mAdminController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    public function __construct()
    {
        parent::__construct();

        // special authentication check for the entire controller: Note the check-ADMIN-authentication!
        // All methods inside this controller are only accessible for admins (= users that have role type 7)
        Auth::checkAdminAuthentication();
    }

    /**
     * This method controls what happens when you move to /admin or /admin/index in your app.
     */
    public function index()
    {
	    $this->View->render('madmin/index', array(
			    'users' => UserModel::getPublicProfilesOfAllUsers())
	    );
    }

    public function category()
    {
        $this->View->render('madmin/category/index', array(
                'categories' => CategoryModel::getAllCategories())
        );
    }

    public function films()
    {
        $this->View->render('madmin/films/index', array(
                'films' => FilmModel::getAllFilms())
        );
    }

	public function actionAccountSettings()
	{
		AdminModel::setAccountSuspensionAndDeletionStatus(
			Request::post('suspension'), Request::post('softDelete'), Request::post('user_id')
		);

		Redirect::to("admin");
	}
}
