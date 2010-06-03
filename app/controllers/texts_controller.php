<?php 
class TextsController extends AppController { 
    function index(){ 
		// Will use the username defined in the $twitter as shown above:
		$texts = $this->Text->find('all');
		//$texts = $this->Text->save(array('To' => 4157175170, 'From' => 4152360978, 'Body' => 'This is an update'));
		// Finds tweets by another username
		//$conditions= array('AccountSid' => 'AccountSid');
		//$otherTweets = $this->Text->find('all', compact('conditions'));
		debug($texts);
	} 
} 
?> 