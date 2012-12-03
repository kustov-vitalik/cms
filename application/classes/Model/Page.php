<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Page extends ORM {

    /**
     * СИСТЕМНЫЕ СТРАНИЧНЫЕ МЕТОДЫ
     */
    protected $_table_name    = 'pages';
    protected $_primary_key   = 'page_id';
    protected $_table_columns = array(
        'page_id'   => NULL,
        'title'     => NULL,
        'url'       => NULL,
        'in_menu'   => NULL,
        'sequence'  => NULL,
        'module_id' => NULL,
        'config_id' => NULL,
    );
    protected $_has_many      = array(
        'widgetsModel' => array(
            'model'       => 'Widget',
            'foreign_key' => 'page_id',
            'through'     => 'page_widget',
            "far_key"     => "widget_id"
        ),
    );
    protected $_belongs_to    = array(
        'moduleModel' => array(
            'model'       => 'Module',
            'foreign_key' => 'module_id'
        ),
        'configModel' => array(
            'model'       => 'Config',
            'foreign_key' => 'config_id'
        ),
    );

    public function rules()
    {
        return array(
            'url'   => array(
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
            'url'      => 'URL СЃС‚СЂР°РЅРёС†С‹',
            'title'    => 'Р—Р°РіРѕР»РѕРІРѕРє СЃС‚СЂР°РЅРёС†С‹',
            'in_menu'  => 'РџРѕРєР°Р· РІ РіР»Р°РІРЅРѕРј РјРµРЅСЋ',
            'position' => 'РџРѕР·РёС†РёСЏ РІ РјРµРЅСЋ',
        );
    }

    public function getTitle()
    {
        return $this->get('title');
    }

    public function getURL()
    {
        return $this->get('url');
    }

    public function getSequence()
    {
        return $this->get('sequence');
    }

    public function inMenu()
    {
        return ($this->get('in_menu') == 1) ? TRUE : FALSE;
    }

    /**
     * МАНИПУЛЯЦИИ СТРАНИЦЕЙ
     */
    protected $isCurrent = FALSE;

    /**
     *
     * @return \Model_Page
     */
    public function setThisCurrent()
    {
        $this->isCurrent = TRUE;
        return $this;
    }

    public function isCurrent()
    {
        return $this->isCurrent;
    }

    /**
     * Сохранить страницу при редактировании
     * @param array $data
     * @return boolean
     * @throws Exception
     */
    public function savePage(array $data)
    {
        $this->_db->begin();

        try
        {

            $this->values($data);
            $this->in_menu = isset($data['in_menu']) ? 1 : 0;
            $this->save();

            $this->_db->commit();
            return TRUE;
        }
        catch (Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
        }
    }

    public function createPage(array $data)
    {

        $this->_db->begin();
        try
        {

            $module = new Model_Module($data['module_id']);
            $config = new Model_Config();
            $config->createConfig(
                    $module->getConfig()
                            ->setType('page_module')
                            ->doEnable()
            );

            $data['config_id'] = $config->pk();
            $data['sequence']  = $this->getNextSequence();
            $this->values($data);
            $this->in_menu     = isset($data['in_menu']) ? 1 : 0;
            $this->save();


            $this->_db->commit();
            return TRUE;
        }
        catch (Kohana_Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    public function getNextSequence()
    {
        $pos = DB::select(array(DB::expr('MAX(sequence)'), 'max'))
                ->from('pages')
                ->limit(1)
                ->execute();
        return $pos[0]['max'] + 1;
    }

    public function removePage()
    {

        $this->_db->begin();

        try
        {


            foreach ($this->getWidgets() as $widget)
            {
                /* @var $widget Model_Widget */
                $this->removeWidget($widget);
            }

            $this->getModule()->sanitize();

            $this->getConfig()->removeConfig();

            $this->delete();

            $this->_db->commit();

            return TRUE;
        }
        catch (Kohana_Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    /**
     * Опустить страницу вниз
     * @return boolean
     * @throws Kohana_Exception
     */
    public function moveDown()
    {

        $this->_db->begin();

        try
        {

            if ($this->loaded())
            {
                /* @var $page Model_Page */
                $page = ORM::factory('page')
                        ->where('sequence', '>', $this->getSequence())
                        ->order_by('sequence', 'ASC')
                        ->limit(1)
                        ->find();

                if ($page->loaded())
                {
                    $needSequence = $page->getSequence();
                    $page->set('sequence', $this->getSequence());
                    $this->set('sequence', $needSequence);
                    $page->save();
                    $this->save();

                    $this->_db->commit();
                    return TRUE;
                }
                else
                {
                    throw new Kohana_Exception("Страница :page не может сменить позицию,
                        так как её позиция минимальна", array(':page' => $this->getTitle()));
                }
            }
            else
            {
                throw new Kohana_Exception("Страница не загружена");
            }
        }
        catch (Kohana_Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    /**
     * Поднять страницу вверх
     * @return boolean
     * @throws Kohana_Exception
     */
    public function moveUp()
    {

        $this->_db->begin();

        try
        {

            if ($this->loaded())
            {
                /* @var $page Model_Page */
                $page = ORM::factory('page')
                        ->where('sequence', '<', $this->getSequence())
                        ->order_by('sequence', 'DESC')
                        ->limit(1)
                        ->find();

                if ($page->loaded())
                {
                    $needSequence = $page->getSequence();
                    $page->set('sequence', $this->getSequence());
                    $this->set('sequence', $needSequence);
                    $page->save();
                    $this->save();
                    $this->_db->commit();
                    return TRUE;
                }
                else
                {
                    throw new Kohana_Exception("Страница :page не может сменить позицию,
                        так как её позиция максимальна", array(':page' => $this->getTitle()));
                }
            }
            else
            {
                throw new Kohana_Exception("Страница не загружена");
            }
        }
        catch (Kohana_Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    /**
     * Установить показ/непоказ ссылки на страницу в главном меню
     * @param string $status
     * @return boolean
     * @throws kohana_Exception
     */
    public function showInMenu($status = 'on')
    {
        $this->_db->begin();

        try
        {
            switch ($status)
            {
                case 'on':
                    $this->set('in_menu', 1);
                    break;
                case 'off':
                    $this->set('in_menu', 0);
                    break;
            }

            $this->save();

            $this->_db->commit();
            return TRUE;
        }
        catch (kohana_Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    /**
     * РАБОТА С МОДУЛЕМ
     */
    protected $module = NULL;

    /**
     * Получить модуль для страницы
     * @return Model_Module
     */
    public function getModule()
    {
        if ($this->module == NULL)
        {
            try
            {
                $module  = $this->moduleModel;
                $modName = 'Module_' . ucfirst(strtolower($module->name));

                if (!class_exists($modName))
                {
                    throw new Kohana_Exception('Модуль не найден!');
                }

                $this->module = new $modName($module->pk());
            }
            catch (Kohana_Exception $exc)
            {
                $this->module = new Module_Error404();
            }

            $this->module->registerPage($this);
        }


        return $this->module;
    }

    /**
     * РАБОТА С ВИДЖЕТАМИ
     */
    protected $widgets = NULL;

    /**
     * Получение массива виджетов на странице
     * @return array()
     */
    public function getWidgets()
    {
        if ($this->widgets == NULL)
        {
            $this->widgets = $this->widgetsModel
                    ->order_by('page_widget.position_id', 'ASC')
                    ->order_by('page_widget.sequence', 'ASC')
                    ->find_all();
            foreach ($this->widgets as $widget)
            {
                /* @var $widget Model_Widget */
                $widget->registerPage($this);
            }
        }
        return $this->widgets;
    }

    public function setWidgets($widgets)
    {
        $this->widgets = $widgets;
        return $this;
    }

    /**
     * Получение виджета с именем $name
     * @param string $name
     * @return \Model_Widget
     */
    public function getWidget($name)
    {
        foreach ($this->getWidgets() as $widget)
        {
            if ($widget instanceof Model_Widget)
            {
                if ($widget->getName() == $name)
                {
                    return $widget->registerPage($this);
                }
            }
        }
    }

    /**
     * Удаление виджета со страницы
     * @param Model_Widget $widget
     * @return boolean
     * @throws ORM_Validation_Exception
     */
    public function removeWidget(Model_Widget $widget)
    {
        $this->_db->begin();

        try
        {
            $widget->registerPage($this)->getConfig()->removeConfig();
            $this->remove('widgetsModel', $widget->pk());

            $this->_db->commit();
            return TRUE;
        }
        catch (Kohana_Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
        }
    }

    /**
     * Добавление виджета на страницу
     * @param Model_Widget $widget
     * @return boolean
     * @throws ORM_Validation_Exception
     */
    public function addWidget(Model_Widget $widget)
    {
        $this->_db->begin();

        try
        {

            $cfgSurrogat = new Model_Config_Surrogat_Widget('widget', $widget->getName());
            $config      = new Model_Config();
            $config->createConfig($cfgSurrogat);

            $position = new Model_Position(array('name' => $cfgSurrogat->getDefaultPosition()));

            $sequence = DB::select(array(DB::expr('MAX(sequence)'), 'maxSequence'))
                    ->from('page_widget')
                    ->where('page_id', '=', $this->pk())
                    ->and_where('position_id', '=', $position->pk())
                    ->execute();

            DB::insert('page_widget', array(
                        'widget_id',
                        'page_id',
                        'config_id',
                        'position_id',
                        'sequence'
                    ))->values(array(
                        $widget->pk(),
                        $this->pk(),
                        $config->pk(),
                        $position->pk(),
                        $sequence[0]['maxSequence'] + 1
                    ))
                    ->execute($this->_db);

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

    /**
     * РАБОТА С КОНФИГУРАЦИЯМИ
     */
    private $config;

    /**
     * Получить настройки модуля для страницы
     * @return Model_Config
     */
    public function getConfig()
    {
        if ($this->config == NULL)
        {
            $this->config = $this->configModel;
        }
        return $this->config;
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

    public function optimize()
    {

        $widgets   = new Model_Widget();
        $configs   = new Model_Config();
        $positions = new Model_Position();

        $map = DB::select()
                ->from('page_widget')
                ->where('page_id', '=', $this->pk())
                ->execute();

        $arrayWidgets = array();
        $arrayConfigs = array();

        foreach ($map as $mapItem)
        {
            array_push($arrayWidgets, $mapItem['widget_id']);
            array_push($arrayConfigs, $mapItem['config_id']);
        }

        $positions = $positions->find_all();
        $widgets   = $widgets->where('widget_id', 'IN', $arrayWidgets)->find_all();
        $configs   = $configs->where('config_id', 'IN', $arrayConfigs)->find_all();


        foreach ($map as $mapItem)
        {

            foreach ($widgets as $widget)
            {
                if ($widget->pk() == $mapItem['widget_id'])
                {

                    foreach ($configs as $config)
                    {
                        if ($config->pk() == $mapItem['config_id'])
                        {
                            $widget->setConfig($config);
                            break;
                        }
                    }

                    foreach ($positions as $position)
                    {
                        if ($position->pk() == $mapItem['position_id'])
                        {
                            $widget->setPosition($position);
                        }
                    }

                    $widget->setSequence($mapItem['sequence']);
                    $widget->registerPage($this);
                    $this->widgets[] = $widget;
                }
            }
        }
    }

}