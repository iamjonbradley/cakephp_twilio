<?php
/**
 * Callback Handler for Twilio REST Requests
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010 Jonathan Bradley (http://iamjonbradley.com)
 * @link          http://iamjonbradley.com
 * @package       twilio
 * @subpackage    twilio.controllers
 * @since         v 1.0.0a
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
 
class CallbacksController extends TwilioAppController {
  
  public $name = 'Callbacks';
  public $uses = array('Twilio.Text');
  
  public function calls () {
    $this->render('blank');
  }
  
  public function texts () {
    $this->send($_GET['Body']);
    $this->render('blank');
  }
	
	public function send ($data, $to = null) {
	  $response = $this->Text->save($_GET['Body'], $to = null);
	  debug ($response);
	}

}
