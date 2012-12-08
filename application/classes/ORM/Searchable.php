<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Searchable
 *
 * @author Виталий
 */
class ORM_Searchable extends Kohana_ORM_Searchable implements Searchable{

    const EVENT_UPDATE_AFTER = 'eventUpdateAfter';
    const EVENT_UPDATE_BEFORE = 'eventUpdateBefore';
    const EVENT_CREATE_AFTER = 'eventCreateAfter';
    const EVENT_CREATE_BEFORE = 'eventCreateBefore';
    const EVENT_DELETE_AFTER = 'eventDeleteAfter';
    const EVENT_DELETE_BEFORE = 'eventDeleteBefore';

    public function __construct($id = NULL)
    {
        Event::factory(ORM_Searchable::EVENT_CREATE_BEFORE, $this);

        Event::factory(ORM_Searchable::EVENT_CREATE_AFTER, $this)
                ->addHandler(new ORM_EventHandler_SearchCreate());

        Event::factory(ORM_Searchable::EVENT_UPDATE_BEFORE, $this);

        Event::factory(ORM_Searchable::EVENT_UPDATE_AFTER, $this)
                ->addHandler(new ORM_EventHandler_SearchUpdate());

        Event::factory(ORM_Searchable::EVENT_DELETE_BEFORE, $this)
                ->addHandler(new ORM_EventHandler_SearchDelete());

        Event::factory(ORM_Searchable::EVENT_DELETE_AFTER, $this);


        parent::__construct($id);
    }

    public function update(\Validation $validation = NULL)
    {
        Event::run(ORM_Searchable::EVENT_UPDATE_BEFORE);
        $return = parent::update($validation);
        Event::run(ORM_Searchable::EVENT_UPDATE_AFTER);
        return $return;
    }

    public function create(\Validation $validation = NULL)
    {
        Event::run(ORM_Searchable::EVENT_CREATE_BEFORE);
        $return = parent::create($validation);
        Event::run(ORM_Searchable::EVENT_CREATE_AFTER);
        return $return;
    }

    public function delete()
    {
        Event::run(ORM_Searchable::EVENT_DELETE_BEFORE);
        $return = parent::delete();
        Event::run(ORM_Searchable::EVENT_DELETE_AFTER);
        return $return;
    }

}

?>
