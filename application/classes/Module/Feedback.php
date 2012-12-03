<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Module_Feedback extends Model_Module {

    public function render()
    {

        Manager_Content::Instance()->setTitle($this->getPage()->getTitle());

        $control = Manager_URL::Instance()->getControl();

        switch ($control)
        {
            case 'thanks':
                return $this->thanks();
                break;
            default:
                return $this->feedback();
                break;
        }
    }

    public function feedback()
    {

        $data   = array();
        $errors = array();



        if (Request::current()->method() == Request::POST)
        {
            $data = Request::current()->post();

            try
            {
                $fb = new Model_Feedback();
                if ($fb->saveFeedBack($data))
                {
                    Session::instance()->set('sender_name', $data['name']);
                    Controller::redirect('/' . $this->getPage()->getURL() . '/thanks');
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }

        $view = View::factory('public/feedback/feedback', array(
                    'data'   => $data,
                    'errors' => $errors,
                    'page'   => $this->getPage()
                ));

        return $view->render();
    }

    public function thanks()
    {

        $rText = $this->getConfigPublic()->getItemValueByItemName('response_text');
        $text  = str_replace('{$^NAME^$}', Session::instance()->get('sender_name'), $rText);

        $view = View::factory('public/feedback/thanks', array(
                    'text' => $text
                ));

        return $view->render();
    }

}