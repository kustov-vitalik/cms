<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AddonPDO extends PDO {

    protected static $_supported_drivers = array(
        'mysql'  => true,
        'mysqli' => true,
        'pgsql'  => true,
        'sqlite' => true,
    );
    protected $_nest_level = 0;

    protected function nestedTransactionsSupported()
    {
        return !empty(self::$_supported_drivers[$this->getAttribute(PDO::ATTR_DRIVER_NAME)]);
    }

    public function __construct($dsn, $username, $passwd, $options)
    {
        parent::__construct($dsn, $username, $passwd, $options);
    }

    public function beginTransaction()
    {
        if (!$this->_nest_level || !$this->nestedTransactionsSupported())
        {
            parent::beginTransaction();
        }
        else
        {
            $this->exec("SAVEPOINT LEVEL{$this->_nest_level}");
        }
        ++$this->_nest_level;
    }

    public function commit()
    {
        --$this->_nest_level;

        if (!$this->_nest_level || !$this->nestedTransactionsSupported())
        {
            parent::commit();
        }
        else
        {
            $this->exec("RELEASE SAVEPOINT LEVEL{$this->_nest_level}");
        }
    }

    public function rollBack()
    {
        --$this->_nest_level;

        if (!$this->_nest_level || !$this->nestedTransactionsSupported())
        {
            parent::rollBack();
        }
        else
        {
            $this->exec("ROLLBACK TO SAVEPOINT LEVEL{$this->_nest_level}");
        }
    }

}