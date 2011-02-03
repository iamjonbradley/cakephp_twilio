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
 * @filesource    /app/models/datasources/twilio_source.php
 * @version       1.1
 * @copyright     Copyright 2010, Life Is Content (http://www.lifeiscontent.net)
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
				'length' => 36,
			),
			'From' => array(
				'type' => 'integer',
				'null' => true,
				'default' => '',
				'length' => 10,
			),
			'To' => array(
				'type' => 'integer',
				'null' => true,
				'default' => '',
				'length' => 10
			),
			'Body' => array(
				'type' => 'string',
				'null' => true,
				'default' => '',
				'length' => 160
			),
			'Status' => array(
				'type' => 'string',
				'null' => true,
				'default' => '',
				'length' => 160
			),
		)
	);

	public function __construct($config = array()) {
	  $config += Configure::read('Twilio');
		$auth = "{$config['sid']}:{$config['token']}";
		$this->Socket = new TwilioSocket("https://{$auth}@api.twilio.com/");
		parent::__construct($config);
	}

	public function listSources() {
		return array('texts');
	}

	public function read($model, $queryData = array()) {
		$response = $this->Socket->get("/{$this->config['version']}/Accounts/{$this->config['sid']}/SMS/Messages.json");
		$results = array();
		foreach ($response['TwilioResponse']['SMSMessages'] as $record) {
			$record = array('Text' => $record['SMSMessage']);
			$results[] = $record;
		}
		return $results;
	}

	public function create($model, $fields = array(), $values = array()) {
		$data = array_combine($fields, $values);
		if ($this->config['environment'] == 'sandbox') {
			$data['Body'] = "{$this->config['sandbox_pin']} {$data['Body']}";
			$data['From'] = $this->config['sandbox_number'];
		}
		$response = $this->Socket->post("/{$this->config['version']}/Accounts/{$this->config['sid']}/SMS/Messages.json", $data);

		if (isset($response['TwilioResponse']['SMSMessage']['Sid'])) {
			$model->setInsertId($response['TwilioResponse']['SMSMessage']['Sid']);
			$model->id = $response['TwilioResponse']['SMSMessage']['Sid'];
			$model->data[$model->alias][$model->primaryKey] = $response['TwilioResponse']['SMSMessage']['Sid'];
			return $response;
		}
		if($model->onError())
		{
			return false;
		}
			return $response;
	}

	public function describe($model) {
		return $this->_schema['texts'];
	}
}

class TwilioSocket extends HttpSocket {
	function post($uri = null, $data = array(), $request = array()) {
		return json_decode(parent::post($uri, $data, $request), true);
	}

	function get($uri = null, $query = array(), $request = array()) {
		return json_decode(parent::get($uri, $query, $request), true);
	}
}
?>