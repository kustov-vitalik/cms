<?php

defined('SYSPATH') or die('No direct script access.');

return array(
    // Application defaults
    'default' => array(
        'current_page'      => array(
            'source' => 'route', // source: "query_string" or "route"
            'key'    => 'page'
        ),
        'total_items'       => 0,
        'items_per_page'    => 10,
        'view'              => 'pagination/basic',
        'auto_hide'         => TRUE,
        'first_page_in_url' => FALSE,
    ),
);