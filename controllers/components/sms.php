<?php
/**
 * Twilio Datasource for sending/recieving SMS Messages
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010 Jonathan Bradley (http://iamjonbradley.com)
 * @link          http://iamjonbradley.com
 * @package       twilio
 * @subpackage    twilio.controllers.components
 * @since         v 1.0.0a
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
 
App::import('Vendor', 'Twilio.twilio/twilio');
class SmsComponent extends Object  {
  
	//called before Controller::beforeFilter()
	function initialize(&$controller, $settings = array()) {
		// saving the controller reference for later use
		$this->controller =& $controller;
	}

	//called after Controller::beforeFilter()
	function startup(&$controller) {
	}

	//called after Controller::beforeRender()
	function beforeRender(&$controller) {
	}

	//called after Controller::render()
	function shutdown(&$controller) {
	}

	//called before Controller::redirect()
	function beforeRedirect(&$controller, $url, $status=null, $exit=true) {
	}

	function redirectSomewhere($value) {
		// utilizing a controller method
		$this->controller->redirect($value);
	}
	
	public function send ($data, $to = null) {
	  $model = ClassRegistry::init('Twilio.Text');
	  $response = $model->save($data['Body'], $to = null);
	  die;
		if($response->IsError)
  	  return ClassRegistry::init('Twilio.Callback')->saveFailed($this->params, $_GET);
	}
}