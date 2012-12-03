# Email Queue

A simple form to queue the emails.

The emails are stored in database and a cron takes care to send.

Developed to Kohana 3.2, this module requires some other modules to work fine.

* For portuguese documentation: [Kohana 3S Tecnologia](http://3stecnologia.com.br/artigos/email-queue-modulo-para-kohana).

# Requeriments

* ORM Module
* [Email Module](https://github.com/crowdfavorite/kohana-email)
* A new table in database

# Installation / Configuration

Clone or add submodule to your project, in the "modules" folder of framework, then:

### Create a new table in database with the name you prefer ###

	CREATE TABLE `emailqueue` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `emailto` varchar(100) NOT NULL,
	  `nameto` varchar(100) DEFAULT NULL,
	  `emailfrom` varchar(100) NOT NULL,
	  `namefrom` varchar(100) DEFAULT NULL,
	  `emailreply` varchar(100) DEFAULT NULL,
	  `namereply` varchar(100) DEFAULT NULL,
	  `subject` varchar(255) NOT NULL,
	  `message` mediumtext NOT NULL,
	  `type` varchar(10) NOT NULL DEFAULT 'text/html',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

### Copy the config example to yours application config

Copy

	/modules/emailqueue/config/emailqueue.php

to

	/application/config/emailqueue.php

Edit the configuration file as needed, exists a variable that define the table name where will be stored the emails.

	return array(
	  // Table name that stored the emails to send
	  'tablename'    => 'emailqueue',
	  
	  // Amount of emails will be send by a cron call
	  'amountToSend' => 100,
	);

# How to use

### Adding emails to queue

	EmailQueue::factory($subject, $message, $type)
	  ->to($emailTo, $nameTo)
	  ->from($emailFrom, $nameFrom)
	  ->reply_to($emailReply, $nameReply)
	  ->save();

### Cron configuration

On your server you need add the cron job like this.

	*/3 * * * * curl -o /tmp/emailqueue http://[application's address]/emailqueue/sendEmails

You can change the interval time for calls as needed. On example a call is executed each 3 minutes.