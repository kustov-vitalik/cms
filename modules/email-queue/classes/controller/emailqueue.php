<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Controller to call the sendEmails action by cron
 *
 * @author Luiz Claudio
 */
class Controller_EmailQueue extends Kohana_Controller {

	/**
	 * Action to send emails by cron
	 *
	 * @author Luiz Claudio
	 */
	public function action_sendEmails(){
		$this->response->body(EmailQueue::sendEmails());
	}
}