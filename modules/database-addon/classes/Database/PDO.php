<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Database_PDO extends Kohana_Database_PDO {

    public function connect()
    {
        if ($this->_connection)
            return;

        // Extract the connection parameters, adding required variabels
        extract($this->_config['connection'] + array(
            'dsn'        => '',
            'username'   => NULL,
            'password'   => NULL,
            'persistent' => FALSE,
        ));

        // Clear the connection parameters for security
        unset($this->_config['connection']);

        // Force PDO to use exceptions for all errors
        $attrs = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

        if (!empty($persistent))
        {
            // Make the connection persistent
            $attrs[PDO::ATTR_PERSISTENT] = TRUE;
        }

        try
        {
            // Create a new AddonPDO connection
            $this->_connection = new AddonPDO($dsn, $username, $password, $attrs);
        }
        catch (PDOException $e)
        {
            throw new Database_Exception(':error', array(':error' => $e->getMessage()), $e->getCode());
        }

        if (!empty($this->_config['charset']))
        {
            // Set the character set
            $this->set_charset($this->_config['charset']);
        }
    }

}