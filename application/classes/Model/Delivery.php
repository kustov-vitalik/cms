<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Delivery extends ORM_Searchable {

    protected $_table_name    = 'delivery';
    protected $_primary_key   = 'delivery_id';
    protected $_table_columns = array(
        'delivery_id' => NULL,
        'title'       => NULL,
        'description' => NULL,
        'cost'        => NULL,
    );

    public function get_indexable_fields()
    {
        $fields = array();

        $fields[] = new Search_Field('delivery_id', Searchable::UNSTORED);
        $fields[] = new Search_Field('title', Searchable::KEYWORD);
        $fields[] = new Search_Field('description', Searchable::TEXT);
        $fields[] = new Search_Field('cost', Searchable::UNSTORED);

        return $fields;
    }

}