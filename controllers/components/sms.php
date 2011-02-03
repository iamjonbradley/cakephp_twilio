<?php

class SmsComponent extends Component {
  
  
  public function send ($message) {
    ClassRegistry::init('Twilio.Text')->create(array('To'=> 9546325387, 'From' => 9545269635, 'Body' => $message));
    // $this->Text->save(array('To'=> $this->to, 'From' => $this->from, 'Body' => $message));
  }
  
}