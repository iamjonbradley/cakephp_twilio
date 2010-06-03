<?php
/**
 * Twilio DataSource
 *
 * Used for reading and writing to Twilio, through models.
 *
 * PHP Version 5.x
 *
 * CakePHP(tm) : Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2010, Life Is Content (http://www.lifeiscontent.net/twilio)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::import('Core', 'HttpSocket');
class TwilioSource extends DataSource {
	protected $_default = array(
		'sid' => null,
		'token' => null,
		'version' => '2008-08-01',
		'environment' => 'production',
		'sandbox_pin' => null,
		'sandbox_number' => null,
	);

	protected $_schema = array(
		'texts' => array(
		    'id' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 34,
			),
			'From' => array(
				'type' => 'integer',
				'null' => true,
				'key' => 'primary',
				'length' => 10,
			),
			'To' => array(
				'type' => 'integer',
				'null' => true,
				'key' => 'primary',
				'length' => 10
			),
			'Body' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 160
			),
		)
	);

	public function __construct($config = array()) {
	    $config += $this->_default;
		$auth = "{$config['sid']}:{$config['token']}";
		$this->connection = new HttpSocket("https://{$auth}@api.twilio.com/");
		parent::__construct($config);
	}

	public function listSources() {
		return array('texts');
	}

	public function read($model, $queryData = array()) {
		$url = "/{$this->config['version']}/Accounts/{$this->config['sid']}/SMS/Messages.json";
		$response = json_decode($this->connection->get($url), true);
		$results = array();
		foreach ($response['TwilioResponse']['SMSMessages'] as $record) {
			$record = array('Text' => $record['SMSMessage']);
			$results[] = $record;
		}
		return $results;
	}

	public function create($model, $fields = array(), $values = array()) {
		$data = array_combine($fields, $values);
		if ($this->config['environment'] == 'sandbox') $data['Body'] = "{$this->config['sandbox_pin']} {$data['Body']}";
		$result = $this->connection->post("/{$this->config['version']}/Accounts/{$this->config['sid']}/SMS/Messages.json", $data);
		$result = json_decode($result, true);
		if (isset($result['TwilioResponse']['SMSMessage']['Sid'])) {
			$model->setInsertId($result['TwilioResponse']['SMSMessage']['Sid']);
			$model->id = $result['TwilioResponse']['SMSMessage']['Sid'];
			return true;
		} else {
			$model->onError();
			return false;
		}
	}

	public function describe($model) {
		return $this->_schema['texts'];
	}
}
?>