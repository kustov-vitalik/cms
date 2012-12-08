<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Module extends ORM {

    protected $_table_name    = 'modules';
    protected $_primary_key   = 'module_id';
    protected $_table_columns = array(
        'title'     => NULL,
        'module_id' => NULL,
        'name'      => NULL,
        'config_id' => NULL,
    );
    protected $_belongs_to    = array(
        'configModel' => array(
            'model'       => 'Config',
            'foreign_key' => 'module_id',
        ),
    );
    protected $_has_many      = array(
        'pages' => array(
            'model'       => 'Page',
            'foreign_key' => 'module_id',
        ),
    );

    public function rules()
    {
        return array(
            'name'  => array(
                array('min_length', array(':value', 4)),
                array('max_length', array(':value', 255)),
                array('not_empty'),
            ),
            'title' => array(
                array('not_empty'),
                array('min_length', array(':value', 4)),
                array('max_length', array(':value', 255)),
            ),
        );
    }

    public function labels()
    {
        return array(
            'title' => 'Название модуля',
            'name'  => 'Системное имя модуля',
        );
    }

    private $page   = NULL;
    private $config = NULL;

    public function registerPage(Model_Page $page)
    {
        $this->page = $page;
    }

    public function getTitle()
    {
        return $this->get('title');
    }

    public function saveModuleConfigs(array $data)
    {
        try
        {
            $this->getConfig()->saveConfigs($data);
            return TRUE;
        }
        catch (Kohana_Exception $exc)
        {
            throw $exc;
            return FALSE;
        }
    }

    /**
     *
     * @return Model_Page
     */
    public function getPage()
    {
        if ($this->page == NULL)
        {
            $page = $this->pages->limit(1)->find();
            $this->registerPage($page);
        }
        return $this->page;
    }

    /**
     * Получить конфиг модуля для страницы
     * @return Model_Config
     */
    public function getConfig()
    {
        if ($this->config == NULL)
        {
            $this->config = $this->configModel
                    ->where('config_id', '=', $this->config_id)
                    ->find();
        }
        return $this->config;
    }

    public function sanitize(array $sanitizedModels)
    {
        $this->_db->begin();
        try
        {
            foreach ($sanitizedModels as $model)
            {
                $models = ORM::factory($model)
                        ->where('page_id', '=', $this->getPage()->pk())
                        ->find_all();

                foreach ($models as $m)
                {
                    $m->delete();
                }
            }

            $this->_db->commit();
            return TRUE;
        }
        catch (Kohana_Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
        }
    }

    public function getName()
    {
        if ($this->loaded())
        {
            return $this->get('name');
        }
    }

    public function saveModule(array $data)
    {

        $this->_db->begin();
        try
        {

            $configSurrogat = new Model_Config_Surrogat('module', $data['name']);



            $configModule = new Model_Config();
            $configModule->createConfig($configSurrogat);

            $data['config_id'] = $configModule->pk();

            $this->values($data);
            $this->save();


            $this->_db->commit();

            return TRUE;
        }
        catch (ORM_Validation_Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    public function removeModule()
    {

        $this->_db->begin();

        try
        {
            foreach ($this->pages->find_all() as $page)
            {
                /* @var $page Model_Page */
                $page->removePage();
            }

            $config = $this->getSelfConfig();
            $this->remove('moduleConfigs', $config->pk());
            $config->removeConfig();

            $this->delete();

            $this->_db->commit();

            return TRUE;
        }
        catch (ORM_Validation_Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    public function getConfigPublic()
    {
        if ($this->getPage()->getConfig()->isEnable())
        {
            return $this->getPage()->getConfig();
        }
        elseif ($this->getConfig()->isEnable())
        {
            return $this->getConfig();
        }
        else
        {
            return new Model_Config_Surrogat('module', $this->getName());
        }
    }

}