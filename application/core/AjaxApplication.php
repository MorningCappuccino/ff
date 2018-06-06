<?php

/**
 * Class AjaxApplication
 */

class AjaxApplication
{

	private $post;

	private $controller_name;

	private $action_name;

	public function __construct()
	{
		$this->post = new stdClass();
		$this->post->parameters = (object) $this->getParameters();
		$this->controller_name = $this->post->parameters->controller_name . 'Controller';
		$this->action_name = $this->post->parameters->action_name;


      if (file_exists(Config::get('PATH_CONTROLLER') . $this->controller_name . '.php')) {
      	require Config::get('PATH_CONTROLLER') . $this->controller_name . '.php';
      	$this->controller = new $this->controller_name();

      	$this->controller->{$this->action_name}($this->post->parameters);
      }

      // echo $this->controller_name . " - controller\n";
		// echo $this->action_name. ' - action';
		// var_dump($this->post->parameters);
    }



    public function getParameters(){
		// check on json
		$post = file_get_contents('php://input');
		if ( $this->isJson($post) ) {
			//is json
			$params = json_decode($post);
		} else {
			//is not json
			$params = $_POST;
		}

    	foreach ($params as $key => $value){
    		$data[$key] = $value;
    	}

    	return $data;
    }

	private function isJson($string) {
	 json_decode($string);
	 $x = json_last_error();
	 return (json_last_error() == JSON_ERROR_NONE);
	}

  }
