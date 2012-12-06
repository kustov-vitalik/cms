<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Admin extends Controller_Base {

    public $template   = 'admin/index';
    public $breadCrumbs;
    private $urlHistory = array(
        'preprev' => NULL,
        'prev'    => NULL,
    );

    public function before()
    {
        parent::before();

        if (!Auth::instance()->logged_in('admin'))
        {
            $this->redirect('/admin/auth/login');
        }


        $this->breadCrumbs = new BreadCrumbs();
        $this->breadCrumbs->addItem(
                new BreadCrumbs_Item(Site::Instance()->getConfig()->get('name'), '/admin')
        );


        $this->urlHistory = array(
            'preprev' => Session::instance()->get('backURL'),
            'prev'    => Request::current()->referrer(),
        );

        Session::instance()->set('backURL', Request::current()->referrer());
    }

    public function after()
    {
        $this->template
                ->set('content', Manager_Content::Instance()->getContent())
                ->set('breadCrumbs', $this->breadCrumbs);
        parent::after();
    }

    public function goBack()
    {
        $this->redirect($this->urlHistory['preprev']);
    }

    /**
     * Получить объект хлебных крошек
     * @return BreadCrumbs
     */
    public function getBreadCrumbs()
    {
        return $this->breadCrumbs;
    }

}