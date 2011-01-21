<?php 
class TextsController extends AppController { 
    function index(){ 
		// Will use the AccountSid defined in the $twilio as shown above:
		$texts = $this->Text->find('all');
		//$texts = $this->Text->save(array('To' => 4155555555, 'From' => 4152360978, 'Body' => 'This is an update'));
		// Finds texts by another AccountSid
		//$conditions= array('AccountSid' => 'AccountSid');
		//$otherTweets = $this->Text->find('all', compact('conditions'));
		debug($texts);
	} 
} 
?> 