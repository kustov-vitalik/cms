<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Widget extends ORM {

    protected $_table_name    = 'widgets';
    protected $_primary_key   = 'widget_id';
    protected $_table_columns = array(
        'widget_id' => NULL,
        'title'     => NULL,
        'name'      => NULL,
        'config_id' => NULL,
    );
    protected $_belongs_to    = array(
        'configModel' => array(
            'model'       => 'Config',
            'foreign_key' => 'config_id'
        ),
    );
    protected $_has_many      = array(
        'pages'     => array(
            'model'       => 'Page',
            'foreign_key' => 'widget_id',
            'through'     => 'page_widget'
        ),
        'configs'   => array(
            'model'       => 'Config',
            'foreign_key' => 'widget_id',
            'through'     => 'page_widget',
            'far_key'     => 'config_id'
        ),
        'positions' => array(
            'model'       => 'Position',
            'foreign_key' => 'widget_id',
            'through'     => 'page_widget'
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
            'title' => 'Название виджета',
            'name'  => 'Системное имя виджета',
        );
    }

    public function getName()
    {
        return $this->get('name');
    }

    public function getTitle()
    {
        return $this->get('title');
    }

    private $page         = NULL;
    private $widgetConfig = NULL;
    private $pageConfig   = NULL;
    private $position     = NULL;

    /**
     * Получить дефолтные настройки виджета
     * @return Model_Config
     */
    public function getSelfConfig()
    {
        if ($this->widgetConfig == NULL)
        {
            if ($this->configModel->loaded())
            {
                $this->widgetConfig = $this->configModel;
            }
            else
            {
                $this->widgetConfig = $this->configModel
                        ->where('config_id', '=', $this->config_id)
                        ->find();
            }
        }

        return $this->widgetConfig;
    }

    /**
     *
     * @param Model_Page $page
     * @return \Model_Widget
     */
    public function registerPage(Model_Page $page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     *
     * @return Model_Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Получение настроек виджета для текущей страницы
     * @return Model_Config
     */
    public function getConfig()
    {
        if ($this->pageConfig == NULL)
        {

            $this->pageConfig = $this->configs
                    ->where('page_widget.page_id', '=', $this->getPage()->pk())
                    ->limit(1)
                    ->find();
        }
        return $this->pageConfig;
    }

    protected $configsForPage = array();

    /**
     *
     * @param Model_Page $page
     * @return Model_Config
     */
    public function getConfigForPage(Model_Page $page)
    {
        if (!isset($this->configsForPage[$page->pk()]) or $this->configsForPage[$page->pk()] == NULL)
        {
            $this->configsForPage[$page->pk()] = $this->configs
                    ->where('page_widget.page_id', '=', $page->pk())
                    ->limit(1)
                    ->find();
        }
        return $this->configsForPage[$page->pk()];
    }


    /**
     *
     * @return Model_Position
     */
    public function getPosition()
    {
        if ($this->position == NULL)
        {
            $this->position = $this->positions
                    ->where('page_widget.page_id', '=', $this->getPage()->pk())
                    ->limit(1)
                    ->find();
        }
        return $this->position;
    }

    protected $positionsForPage = array();

    /**
     * Получить позицию виджета для страницы $page
     * @param Model_Page $page
     * @return Model_Position
     */
    public function getPositionForPage(Model_Page $page)
    {
        if (!isset($this->positionsForPage[$page->pk()]) or $this->positionsForPage[$page->pk()] == NULL)
        {
            $this->positionsForPage[$page->pk()] = $this->positions
                    ->where('page_widget.page_id', '=', $page->pk())
                    ->limit(1)
                    ->find();
        }
        return $this->positionsForPage[$page->pk()];
    }

    public function getPositionName()
    {
        return $this->getPosition()->getName();
    }

    public function savePositionForPage($position_id, Model_Page $page)
    {
        $this->registerPage($page);

        if ($this->getPosition()->pk() == $position_id)
        {
            return TRUE;
        }

        $this->_db->begin();

        try
        {

            $sequence = DB::select(array(DB::expr('MAX(sequence)'), 'max_sequence'))
                    ->from('page_widget')
                    ->where('page_id', '=', $this->getPage()->pk())
                    ->and_where('position_id', '=', $position_id)
                    ->execute();

            $query = DB::update('page_widget')
                    ->where('page_id', '=', $this->getPage()->pk())
                    ->and_where('widget_id', '=', $this->pk())
                    ->set(
                    array(
                        'position_id' => $position_id,
                        'sequence'    => $sequence[0]['max_sequence'] + 1
                    )
            );

            $query->execute();

            $this->_db->commit();
            return TRUE;
        }
        catch (Kohana_Exception $e)
        {
            $this->_db->rollback();
            throw $e;
            return FALSE;
        }
    }

    public function saveConfigsForPage(array $configs, Model_Page $page)
    {
        $this->registerPage($page);

        if ($this->getConfig()->saveConfigs($configs))
        {
            return TRUE;
        }

        return FALSE;
    }

    public function saveWidget(array $data)
    {

        $this->_db->begin();

        try
        {
            $this->values($data);
            $this->save();

            $this->_db->commit();
            return TRUE;
        }
        catch (Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    /**
     * Создание виджета
     * @param array $data
     * @return boolean
     * @throws Exception
     */
    public function createWidget(array $data)
    {

        $this->_db->begin();

        try
        {
            $cfgSurrogat = new Model_Config_Surrogat('widget', $data['name']);
            $config      = new Model_Config();
            $config->createConfig($cfgSurrogat->setType('widget_default')->doEnable());

            $data['config_id'] = $config->pk();
            $this->values($data);
            $this->save();


            $this->_db->commit();
            return TRUE;
        }
        catch (Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    public function deleteWidget()
    {

        $this->_db->begin();

        try
        {

            $relatedPages = $this->pages->find_all();
            foreach ($relatedPages as $page)
            {
                /* @var $page Model_Page */

                $this->getConfigForPage($page)->removeConfig();
                $this->remove('pages', $page->pk());
            }

            $config = $this->getSelfConfig();
            $this->remove('widgetConfigs', $config->pk());
            $config->removeConfig();

            $this->delete();
            $this->_db->commit();
            return TRUE;
        }
        catch (Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    public static function getMaxSequenceForPage(Model_Page $page)
    {
        $maxPosition = DB::select(array(DB::expr('MAX(sequence)'), 'max_position'))
                ->from('page_widget')
                ->and_where('page_id', '=', $page->pk())
                ->and_where('position_id', '=', $this->getPositionForPage($page)->pk())
                ->execute($this->_db);

        return $maxPosition[0]['max_position'];
    }

    public static function getMinSequenceForPage(Model_Page $page)
    {
        $minPosition = DB::select(array(DB::expr('MIN(sequence)'), 'min_position'))
                ->from('page_widget')
                ->and_where('page_id', '=', $page->pk())
                ->and_where('position_id', '=', $this->getPositionForPage($page)->pk())
                ->execute($this->_db);

        return $minPosition[0]['min_position'];
    }

    public function getSequenceOnPage(Model_Page $page)
    {

        $inner = DB::select('sequence')
                ->from('page_widget')
                ->where('widget_id', '=', $this->pk())
                ->and_where('page_id', '=', $page->pk())
                ->and_where('position_id', '=', $this->getPositionForPage($page)->pk())
                ->limit(1)
                ->execute($this->_db);

        return $inner[0]['sequence'];
    }

    public function setSequenceOnPageCurrentPosition(Model_Page $page, $sequence)
    {
        $this->_db->begin();

        try
        {

            DB::update('page_widget')
                    ->value('sequence', $sequence)
                    ->where('widget_id', '=', $this->pk())
                    ->and_where('page_id', '=', $page->pk())
                    ->and_where('position_id', '=', $this->getPositionForPage($page)->pk())
                    ->execute();

            $this->_db->commit();

            return TRUE;
        }
        catch (Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    public function moveOnPageCurrentPosition(Model_Page $page, $to = 'up')
    {

        $this->_db->begin();

        try
        {
            if ($this->loaded())
            {
                switch ($to)
                {
                    case 'up':
                        $qArr = array(
                            'operation' => '<',
                            'ordering'  => 'DESC'
                        );
                        break;
                    case 'down':
                        $qArr = array(
                            'operation' => '>',
                            'ordering'  => 'ASC'
                        );
                        break;
                }

                $temp = DB::select('widget_id')
                        ->from('page_widget')
                        ->where('page_id', '=', $page->pk())
                        ->and_where('position_id', '=', $this->getPositionForPage($page)->pk())
                        ->and_where('sequence', $qArr['operation'], $this->getSequenceOnPage($page))
                        ->order_by('sequence', $qArr['ordering'])
                        ->limit(1)
                        ->execute();

                $topWidget = new Model_Widget($temp[0]['widget_id']);

                if ($topWidget->loaded())
                {
                    $tempSequence = $this->getSequenceOnPage($page);
                    if ($this->setSequenceOnPageCurrentPosition($page, $topWidget->getSequenceOnPage($page)) and $topWidget->setSequenceOnPageCurrentPosition($page, $tempSequence))
                    {
                        $this->_db->commit();
                        return TRUE;
                    }
                    else
                    {
                        throw new Kohana_Exception("Неизвестная ошибка");
                    }
                }
                else
                {
                    throw new Kohana_Exception("Виджет не может быть перемещён.");
                }
            }
            else
            {
                throw new Kohana_Exception("Виджет не загружен");
            }
        }
        catch (Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    public function saveWidgetConfigs(array $data)
    {
        $this->_db->begin();

        try
        {
            $this->getSelfConfig()->saveConfigs($data);
            $this->_db->commit();
            return TRUE;
        }
        catch (Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    public function render()
    {
        $params = array();

        if ($this->getConfig()->isEnable())
        {
            $it = $this->getConfig()->getItems()->getIterator();
        }
        elseif ($this->getSelfConfig()->isEnable())
        {
            $it = $this->getSelfConfig()->getItems()->getIterator();
        }
        else
        {
            $config = new Model_Config_Surrogat_Widget('widget', $this->getName());
            $it     = $config->getItems()->getIterator();
        }


        $it->rewind();
        while ($it->valid())
        {
            $item = $it->current();

            if ($item instanceof Config_Item_Interface)
            {
                $params[$item->getName()] = $item->getValue();
            }

            $it->next();
        }

        return Widget::load($this->getName(), array(
                    'param' => urlencode(serialize($params))
                ));
    }

}