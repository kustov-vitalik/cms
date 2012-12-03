<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
interface Config_Item_Interface {
    /**
     * Getters
     */

    /**
     * Получить системное имя настройки
     * @return string Системное имя настройки
     */
    public function getName();

    /**
     * Получить Название настройки
     * @return string Название настройки
     */
    public function getTitle();

    /**
     * Получить Описание настройки
     * @return string Описание настройки
     */
    public function getDescription();

    /**
     * Получить Тип настройки
     * @return string Тип настройки
     */
    public function getType();

    /**
     * Получить значение настройки
     * @return string Значение настройки
     */
    public function getValue();

    /**
     * Получить коллекцию возможных значений настройки
     * @return Collection Коллекция
     */
    public function getAvailableValues();

    /**
     * Получить группу настроек текущей настройки
     * @return Config_Interface Группа настроек
     */
    public function getConfig();

    /**
     * Setters
     */

    /**
     * Установить Системное имя настройки
     * @param string $name
     * @return Config_Item_Intrerface Настройка
     */
    public function setName($name);

    /**
     * Установить Название настройки
     * @param string $title
     * @return Config_Item_Intrerface Настройка
     */
    public function setTitle($title);

    /**
     * Установить Описание настройки
     * @param string $description
     * @return Config_Item_Intrerface Настройка
     */
    public function setDescription($description);

    /**
     * Установить Тип настройки
     * @param string $type
     * @return Config_Item_Intrerface Настройка
     */
    public function setType($type);

    /**
     * Установить Значение настройки
     * @param string $value
     * @return Config_Item_Intrerface Настройка
     */
    public function setValue($value);

    /**
     * Установить возможные значения настройки
     * @param Config_Item_AvailableValue_Collection $availableValues
     * @return Config_Item_Intrerface Настройка
     */
    public function setAvailableValues(Collection_Interface $availableValues);

    /**
     * Установить Группу настроек для настройки
     * @param Config_Interface $config
     * @return Config_Item_Intrerface Настройка
     */
    public function setConfig(Config_Interface $config);
}