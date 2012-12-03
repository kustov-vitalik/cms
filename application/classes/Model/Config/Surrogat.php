<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Config_Surrogat extends Config_Empty {

    public function __construct($configType, $configName)
    {

        $config = NULL;

        switch ($configType)
        {
            case 'module':
                $config = Kohana::$config->load('module');
                break;
            case 'widget':
                $config = Kohana::$config->load('widget');
                break;
            default :
                throw new Kohana_Exception('Entity type :type not found in system', array(
                    ':type' => $configType
                ));
                break;
        }

        $configGroup = $config->get($configName);

        if ($configGroup == NULL)
        {
            throw new Kohana_Exception('Entity :ent not found in system', array(
                ':ent' => $configName
            ));
        }

        $this->setName($configGroup['name'])
                ->setTitle($configGroup['title'])
                ->setDescription($configGroup['description'])
                ->doEnable()
                ->setType($configGroup['type']);

        $configItemsGroup = $configGroup['group'];

        $configItemsSurrogat = CollectionFactory::create('Model_Config_Item_Surrogat');

        foreach ($configItemsGroup as $item)
        {
            $configItemSurrogat = new Model_Config_Item_Surrogat();

            $configItemSurrogat->setConfig($this);
            $configItemSurrogat->setName($item['name']);
            $configItemSurrogat->setTitle($item['title']);
            $configItemSurrogat->setDescription($item['description']);
            $configItemSurrogat->setValue($item['value']);
            $configItemSurrogat->setType($item['type']);


            $configItemsAvailableValuesSurrogat =
                    CollectionFactory::create('Model_Config_Item_AvailableValue_Surrogat');

            foreach ($item['availableValues'] as $availableValue)
            {
                $avValue = new Model_Config_Item_AvailableValue_Surrogat();
                $avValue->setConfigItem($configItemSurrogat);
                $avValue->setValue($availableValue['value']);
                $configItemsAvailableValuesSurrogat->add($avValue);
            }

            $configItemSurrogat->setAvailableValues($configItemsAvailableValuesSurrogat);

            $configItemsSurrogat->add($configItemSurrogat);
        }

        $this->setItems($configItemsSurrogat);

    }

}