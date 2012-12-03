<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Ulogin extends Model_Kohana_Ulogin {

    protected $_table_columns = array(
        'id'       => NULL,
        'user_id'  => NULL,
        'network'  => NULL,
        'identity' => NULL,
    );

}