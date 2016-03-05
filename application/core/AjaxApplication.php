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
		$this->controller_name = Request::post('controller_name') . 'Controller';
		$this->action_name = Request::post('action_name');
		$this->post->parameters = $this->getParameters();


      if (file_exists(Config::get('PATH_CONTROLLER') . $this->controller_name . '.php')) {
      	require Config::get('PATH_CONTROLLER') . $this->controller_name . '.php';
      	$this->controller = new $this->controller_name();

      	$this->controller->{$this->action_name}((object)$this->post->parameters);
      }

      // echo $this->controller_name . " - controller\n";
		// echo $this->action_name. ' - action';
		// var_dump($this->post->parameters);
    }



    public function getParameters(){
    	foreach ($_POST as $key => $value){
    		$data[$key] = $value;
    	}
    	unset($data['controller_name']);
    	unset($data['action_name']);
    	return $data;
    }

  }