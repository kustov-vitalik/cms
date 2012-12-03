<?php defined('SYSPATH') or die('No direct script access.');

return array(

	// Table name that stored the emails to send
	'tablename'			=> 'emailqueue',

	// Amount of emails will be send by a cron call
	'amountToSend'		=> 100,
);