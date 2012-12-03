<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Model EmailQueue
 *
 * @author Luiz Claudio
 */
class Model_EmailQueue extends ORM {

	// Table name, this value comes from config file of module through constructor method
	protected $_table_name = '';

	/**
	 * Sets the table name and returns the parent constructor
	 *
	 * @author Luiz Claudio
	 * @param  $id
	 * @return parent::__construct
	 */
	public function __construct($id = NULL) {

		// Gets the configuration
		$config = $this->getConfiguration();
		extract($config, EXTR_SKIP);

		// Sets the table name
		$this->_table_name = $tablename;

		return parent::__construct($id);
	}

	/**
	 * Sets the subject, message content and mime type of email queue
	 *
	 * @param  string $subject
	 * @param  string $message
	 * @param  string $type
	 * @return Model_EmailQueue
	 */
	public function add($subject = NULL, $message = NULL, $type = 'text/html') {
		$this->setSubject($subject);
		$this->setMessage($message);
		$this->setType($type);
		return $this;
	}

	/**
	 * Sets the subject for the email queue
	 *
	 * @author Luiz Claudio
	 * @param  string  message $subject
	 * @return Model_EmailQueue
	 */
	public function setSubject($subject) {
		$this->subject = $subject;
		return $this;
	}

	/**
	 * Sets the message content for the email queue
	 *
	 * @author Luiz Claudio
	 * @param  string  $message body
	 * @return Model_EmailQueue
	 */
	public function setMessage($message) {
		$this->message = $message;
		return $this;
	}

	/**
	 * Sets the mime type for the email queue
	 *
	 * @author Luiz Claudio
	 * @param  string  body mime $type
	 * @return Model_EmailQueue
	 */
	public function setType($type) {
		$this->type = $type;
		return $this;
	}

	/**
	 * Sets the email address and the name from
	 *
	 * @author Luiz Claudio
	 * @param  string $email from
	 * @param  string $name from
	 * @return Model_EmailQueue
	 */
	public function setFrom($email, $name) {
		$this->emailfrom = $email;
		$this->namefrom = $name;
		return $this;
	}

	/**
	 * Sets the email address and the name to
	 *
	 * @author Luiz Claudio
	 * @param  string $email to
	 * @param  string $name to
	 * @return Model_EmailQueue
	 */
	public function setTo($email, $name) {
		$this->emailto = $email;
		$this->nameto = $name;
		return $this;
	}

	/**
	 * Sets the email address and the name to reply
	 *
	 * @author Luiz Claudio
	 * @param  string $email reply
	 * @param  string $name reply
	 * @return Model_EmailQueue
	 */
	public function setReply_to($email, $name) {
		$this->emailreply = $email;
		$this->namereply = $name;
		return $this;
	}

	/**
	 * Function to returns the configuration's module
	 *
	 * @author Luiz Claudio
	 * @param  boolean $as_array, default true
	 * @return array or Config Object
	 */
	public function getConfiguration($as_array = true) {
		$config = Kohana::$config->load('emailqueue');
		if ($as_array)
			return $config->as_array();
		else
			return $config;
	}

	/**
	 * This function manages the sending of emails
	 *
	 * @author Luiz Claudio
	 */
	public function sendEmails() {
		// Gets configuration
		$config = $this->getConfiguration();

		// Gets emails from database
		$emails = $this
				->limit($config['amountToSend'])
				->find_all();

		// Send emails
		foreach ($emails as $email) {
			$mail = new Zend_Mail();
			$mail->setSubject($email->subject);
			$mail->setType($email->type);

			if ($email->type == 'text/html') {
				$mail->setBodyHtml($email->message);
			} else {
				$mail->setBodyText($email->message);
			}

			// Standard variables
			$mail->setFrom($email->emailfrom, $email->namefrom);
			$mail->addTo($email->emailto, $email->nameto);
			$mail->setDate();

			// With reply address
			$mail->setReplyTo($email->emailreply, $email->namereply);

			// Send
			if ($mail->send()) {
				try {
					$email->set('is_deleted', 1)->save();
				} catch (ORM_Validation_Exception $exc) {
					ErrorManager::getInstance()->setErrors($exc->errors());
				}

				unset($mail);
			}
		}
		return true;
	}

}