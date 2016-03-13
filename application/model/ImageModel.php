<?php

class ImageModel
{
	// private static $file_tmp_name;

	// public function __construct()
	// {
	 // $this->file_tmp_name = $_FILES['uploadFile']['tmp_name'][0];
	// }

	 // public $file_tmp_name = $_FILES['uploadFile']['tmp_name'][0];

	    /**
     * Gets the user's avatar file path
     * @param int $user_has_avatar Marker from database
     * @param int $user_id User's id
     * @return string Avatar file path
     */
	    public static function getPublicAvatarFilePathOfUser($user_has_avatar, $user_id)
	    {
	    	if ($user_has_avatar) {
	    		return Config::get('URL') . Config::get('PATH_AVATARS_PUBLIC') . $user_id . '.jpg';
	    	}

	    	return Config::get('URL') . Config::get('PATH_AVATARS_PUBLIC') . Config::get('AVATAR_DEFAULT_IMAGE');
	    }

	 /**
     * Gets the user's avatar file path
     * @param $user_id integer The user's id
     * @return string avatar picture path
     */
	    public static function getPublicUserAvatarFilePathByUserId($user_id)
	    {
	    	$database = DatabaseFactory::getFactory()->getConnection();

	    	$query = $database->prepare("SELECT user_has_avatar FROM users WHERE user_id = :user_id LIMIT 1");
	    	$query->execute(array(':user_id' => $user_id));

	    	if ($query->fetch()->user_has_avatar) {
	    		return Config::get('URL') . Config::get('PATH_AVATARS_PUBLIC') . $user_id . '.jpg';
	    	}

	    	return Config::get('URL') . Config::get('PATH_AVATARS_PUBLIC') . Config::get('AVATAR_DEFAULT_IMAGE');
	    }

	    public static function createImage()
	    {
	    	switch ($_FILES['uploadFile']['error'][0]){
	    		case 4: return 'file didnt upload';
	    	}
	    	
        // check avatar folder writing rights, check if upload fits all rules
	    	if (self::isUploadFolderWritable() AND $ext = self::validateImageFile()) {
            // create a jpg file in the avatar folder, write marker to database
	    		$file_tmp_name = $_FILES['uploadFile']['tmp_name'][0];
	    		$img_hash = sha1_file($file_tmp_name);

	    		move_uploaded_file( $file_tmp_name, 
	    			sprintf(Config::get('PATH_UPLOADS') . '%s.%s',
           				  $img_hash, $ext ));

	    			return $img_hash;
	    		// self::writeAvatarToDatabase(Session::get('user_id'));
	    		// Session::set('user_uploadfile', self::getPublicUserAvatarFilePathByUserId(Session::get('user_id')));
	    		// Session::add('feedback_positive', Text::get('FEEDBACK_UPLOAD_SUCCESSFUL'));
	    	}
	    }

	    // public static function updateImage()
	    // {
	    // 	if($_FILES['uploadFile']['tmp_name'][0]){
	    // 		ImageModel::createImage();
	    // 	} else {

	    // 	}

	    // }

	    public static function isUploadFolderWritable()
	    {
	    	if (is_dir(Config::get('PATH_UPLOADS')) AND is_writable(Config::get('PATH_UPLOADS'))) {
	    		return true;
	    	}

	    	Session::add('feedback_negative', Text::get('FEEDBACK_FOLDER_DOES_NOT_EXIST_OR_NOT_WRITABLE'));
	    	return false;
	    }

	    public static function validateImageFile()
	    {
	    	$file_tmp_name = $_FILES['uploadFile']['tmp_name'][0];//bad - put this in class property

	    	if (!isset($_FILES['uploadFile'])) {
	    		Session::add('feedback_negative', Text::get('FEEDBACK_IMAGE_UPLOAD_FAILED'));
	    		return false;
	    	}

        // if input file too big (>5MB)
	    	if ($_FILES['uploadFile']['size'][0] > 5000000) {
	    		Session::add('feedback_negative', Text::get('FEEDBACK_UPLOAD_TOO_BIG'));
	    		return false;
	    	}

        // get the image width, height and mime type
	    	$image_proportions = getimagesize($file_tmp_name);

        // if input file too small, [0] is the width, [1] is the height
	    	if ($image_proportions[0] < Config::get('AVATAR_SIZE') OR $image_proportions[1] < Config::get('AVATAR_SIZE')) {
	    		Session::add('feedback_negative', Text::get('FEEDBACK_UPLOAD_TOO_SMALL'));
	    		return false;
	    	}

        // if file type is not jpg, gif or png
	    	if (!in_array($image_proportions['mime'], array('image/jpeg', 'image/gif', 'image/png'))) {
	    		Session::add('feedback_negative', Text::get('FEEDBACK_UPLOAD_WRONG_TYPE'));
	    		return false;
	    	}

	    	// DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
	    	// Check MIME Type by yourself.
	    	    $finfo = new finfo(FILEINFO_MIME_TYPE);
	    	    if (false === $ext = array_search(
	    	        $finfo->file($file_tmp_name),
	    	        array(
	    	            'jpg' => 'image/jpeg',
	    	            'png' => 'image/png',
	    	            'gif' => 'image/gif',
	    	        ),
	    	        true
	    	    )) {
	    	        throw new RuntimeException('Invalid file format.');
	    	    }

	    	return $ext;
	    }

	    public static function writeAvatarToDatabase($user_id)
	    {
	    	$database = DatabaseFactory::getFactory()->getConnection();

	    	$query = $database->prepare("UPDATE users SET user_has_avatar = TRUE WHERE user_id = :user_id LIMIT 1");
	    	$query->execute(array(':user_id' => $user_id));
	    }

	    public static function deleteAvatar($userId)
	    {
	    	if (!ctype_digit($userId)) {
	    		Session::add("feedback_negative", Text::get("FEEDBACK_AVATAR_IMAGE_DELETE_FAILED"));
	    		return false;
	    	}

        // try to delete image, but still go on regardless of file deletion result
	    	self::deleteAvatarImageFile($userId);

	    	$database = DatabaseFactory::getFactory()->getConnection();

	    	$sth = $database->prepare("UPDATE users SET user_has_avatar = 0 WHERE user_id = :user_id LIMIT 1");
	    	$sth->bindValue(":user_id", (int)$userId, PDO::PARAM_INT);
	    	$sth->execute();

	    	if ($sth->rowCount() == 1) {
	    		Session::set('user_uploadfile', self::getPublicUserAvatarFilePathByUserId($userId));
	    		Session::add("feedback_positive", Text::get("FEEDBACK_AVATAR_IMAGE_DELETE_SUCCESSFUL"));
	    		return true;
	    	} else {
	    		Session::add("feedback_negative", Text::get("FEEDBACK_AVATAR_IMAGE_DELETE_FAILED"));
	    		return false;
	    	}
	    }
        /**
     * Removes the avatar image file from the filesystem
     *
     * @param integer $userId
     * @return bool
     */
        public static function deleteAvatarImageFile($userId)
        {
        // Check if file exists
        	if (!file_exists(Config::get('PATH_AVATARS') . $userId . ".jpg")) {
        		Session::add("feedback_negative", Text::get("FEEDBACK_AVATAR_IMAGE_DELETE_NO_FILE"));
        		return false;
        	}

        // Delete avatar file
        	if (!unlink(Config::get('PATH_AVATARS') . $userId . ".jpg")) {
        		Session::add("feedback_negative", Text::get("FEEDBACK_AVATAR_IMAGE_DELETE_FAILED"));
        		return false;
        	}

        	return true;
        }
      }