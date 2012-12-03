<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Email Queue module
 *
 * @author Luiz Claudio
 */
class EmailQueue_Core {

	// Current module version
	const VERSION	= '0.1.0';

	// Model_EmailQueue
	public $queue	= null;

	/**
	 * Create a new email queue
	 *
	 * @author Luiz Claudio
	 * @param  string  message subject
	 * @param  string  message body
	 * @param  string  body mime type
	 * @return EmailQueue
	 */
	public static function factory($subject = NULL, $message = NULL, $type = 'text/html'){
		return new EmailQueue($subject, $message, $type);
	}

	/**
	 * Class constructor
	 *
	 * @author Luiz Claudio
	 * @param  string  message subject
	 * @param  string  message body
	 * @param  string  body mime type
	 * @return EmailQueue
	 */
	public function __construct($subject = NULL, $message = NULL, $type = 'text/html'){
		$this->queue	= ORM::factory('emailqueue')->add($subject, $message, $type);
		return $this;
	}

	/**
	 * Sets the subject for the email queue
	 *
	 * @author Luiz Claudio
	 * @param  string  message $subject
	 * @return EmailQueue
	 */
	public function subject($subject){
		$this->queue->setSubject($subject);
		return $this;
	}

	/**
	 * Sets the message content for the email queue
	 *
	 * @author Luiz Claudio
	 * @param  string  $message body
	 * @return EmailQueue
	 */
	public function message($message){
		$this->queue->setMessage($message);
		return $this;
	}

	/**
	 * Sets the mime type for the email queue
	 *
	 * @author Luiz Claudio
	 * @param  string  body mime $type
	 * @return EmailQueue
	 */
	public function type($type){
		$this->queue->setType($type);
		return $this;
	}

	/**
	 * Sets the email address and the name from
	 *
	 * @author Luiz Claudio
	 * @param  string $email from
	 * @param  string $name from
	 * @return EmailQueue
	 */
	public function from($email, $name = null){
		$this->queue->setFrom($email, $name);
		return $this;
	}

	/**
	 * Sets the email address and the name to
	 *
	 * @author Luiz Claudio
	 * @param  string $email to
	 * @param  string $name to
	 * @return EmailQueue
	 */
	public function to($email, $name = null){
		$this->queue->setTo($email, $name);
		return $this;
	}

	/**
	 * Sets the email address and the name to reply
	 *
	 * @author Luiz Claudio
	 * @param  string $email reply
	 * @param  string $name reply
	 * @return EmailQueue
	 */
	public function reply_to($email, $name = null){
		$this->queue->setReply_to($email, $name);
		return $this;
	}

	/**
	 * Call the save method of Model to persist in the Database
	 *
	 * @author Luiz Claudio
	 * @return boolean
	 */
	public function save(){
		if($this->queue->save())
			return true;
		else
			return false;
	}

	/**
	 * Static function to returns the configuration's module
	 *
	 * @author Luiz Claudio
	 * @param  boolean $as_array, default true
	 * @return array or Config Object
	 */
	public static function getConfiguration($as_array = true){
		return ORM::factory('emailqueue')->getConfiguration($as_array);
	}

	/**
	 * Static function called by the controller to send the emails
	 *
	 * @author Luiz Claudio
	 */
	public static function sendEmails(){
		return ORM::factory('emailqueue')->sendEmails();
	}

}
