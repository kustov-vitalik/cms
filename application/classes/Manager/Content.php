<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Manager_Content {

    private $title = "";
    private $content = "";
    private $menu = "";
    private $jsText = "", $isJsText = FALSE;
    private $scripts = array(), $styles = array();
    private static $_instance = NULL;

    private function __construct() {
        ;
    }

    private function __clone() {
        ;
    }

    /**
     *
     * @return Manager_Content
     */
    public static function Instance() {
        if (self::$_instance == NULL)
            self::$_instance = new self();
        return self::$_instance;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getScripts() {
        return $this->scripts;
    }

    public function addScript($script) {
        if (in_array($script, $this->scripts)) {
            return $this;
        }
        array_push($this->scripts, $script);
        return $this;
    }

    public function getStyles() {
        return $this->styles;
    }

    public function addStyle($style) {
        if (in_array($style, $this->styles)) {
            return $this;
        }
        array_push($this->styles, $style);
        return $this;
    }

    public function getBreadCrumbs() {

        $titles = array(
            Kohana::$config->load('site')->get('name'),
            $this->getTitle()
        );

        $content = View::factory('manager/content/breadcrumbs', array(
                    'titles' => $titles
                ));
        return $content;
    }

    public function addCKEditorToElement($elem) {
        $this->addScript('/media/ckeditor/ckeditor.js');
        $this->setJsText("CKEDITOR.replace('{$elem}');");
        return $this;
    }

    public function getJsText() {
        return $this->jsText;
    }

    /**
     *
     * @param type $jsText
     * @return \Manager_Content
     */
    public function setJsText($jsText) {
        $this->isJsText = TRUE;
        $this->jsText .= $jsText;
        return $this;
    }

    public function isJsText() {
        return $this->isJsText;
    }




}