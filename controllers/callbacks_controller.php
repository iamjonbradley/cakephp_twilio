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
  
  public $components = array('Twilio.Sms');
  
  public function calls () {
    $this->render('blank');
    exit();
  }
  
  public function texts () {
    $this->Sms->send($_GET['Body']);
    exit();
  }

}
