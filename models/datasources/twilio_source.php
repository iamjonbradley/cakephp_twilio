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
 * @subpackage    twilio.model.datasources
 * @since         v 1.0.0a
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
 
App::import('Core', 'File');
App::import('Vendor', 'Twilio.twilio/twilio');
class TwilioSource extends DataSource {
  
  public $config = array();

	public function __construct($config = array()) {
	  $this->config = Configure::read('Twilio');
	  $this->client = new TwilioRestClient($this->config['sid'], $this->config['token']);
		parent::__construct($this->config);
	}
	
  public function create ($model, $msg, $sendTo = null) {
    
    if (empty($sendTo))   
      $sendTo = $this->config['SendTo'];
      
      debug ($this->version);
      die;
    
    $host = $this->config['version'] ."/Accounts/". $this->config['sid'] ."/SMS/Messages";
    $args = array('To'=> $sendTo, 'From' => $this->config['From'], 'Body' => $msg);
    
    $response = $this->client->request($host, "POST", $args);
    
		if($response->IsError)
			return "Error: {$response->ErrorMessage}";
		else
			return "Sent message to ". $conditions['To'];
    return $response;
  }
}