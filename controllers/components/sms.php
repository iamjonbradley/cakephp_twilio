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
class SmsComponent extends Component {
	
	public function send ($data, $to = null) {
	  $response = ClassRegistry::init('Twilio.Text')->save($data['Body'], $to = null);
	  die;
		if($response->IsError)
  	  return ClassRegistry::init('Twilio.Callback')->saveFailed($this->params, $_GET);
	}
  
}