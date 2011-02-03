<?php

class TestingController extends TwilioAppController {
  
  var $uses = array();
  var $components = array('Twilio.Sms');
  
  function send_notice($amount, $store, $from) {
    $this->Sms->send("NEW SALE SENT TO: $store | FOR $: $amount DOLLARS | BY $from");
  }
  
  function sms () {
    $this->Text->save(array('To'=>9542979283, 'From'=>4155992671, 'Body' => 'This is a text message'));
    exit();
  }

}
