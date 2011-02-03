<?php

App::import('Core', 'File');
class CallbacksController extends TwilioAppController {
  
  var $uses = array();
  var $components = array('Twilio.Sms');
  
  function calls () {
    $this->__save();
    $this->render('blank');
  }
  
  function texts () {
    $this->Sms->send($_GET['Body']);
    $this->__save();
    $this->render('blank');
  }
  
  private function __save() {
    
    // set filename
    $time = microtime();
    $time = str_replace(array('.', ' '), '', $time);
    $time = $time .'.txt';
    
    // set the path
    $path =  TMP .'incomming'. DS . $this->params['action'] . DS . $time;
    $body = serialize($_GET['Body']);
    
    // save the response
    $this->File = new File($path, 'w', true);
    $this->File->write($body);
    $this->File->close();
    return true;
  }

}
