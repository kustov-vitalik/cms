<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class BreadCrumbs_Item {

    private $title;
    private $url;

    function __construct($title, $url)
    {
        $this->title = $title;
        $this->url   = $url;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getUrl()
    {
        return $this->url;
    }

}