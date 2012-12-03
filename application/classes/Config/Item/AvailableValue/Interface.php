<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
interface Config_Item_AvailableValue_Interface {
    /**
     * Getters
     */

    /**
     * Получить системное имя возможного значения настройки
     * @return string Системное имя возможного значения настройки
     */
    public function getValue();

    /**
     * Получить настройку
     * @return Config_Item_Interface Настройка
     */
    public function getConfigItem();

    /**
     * Setters
     */

    /**
     * Установить Значение возможного значения настройки
     * @param string $value
     * @return Config_Item_AvailableValue_Interface Текущий объект
     */
    public function setValue($value);

    /**
     * Установить настройку возможного значения настройки
     * @param Config_Item_Interface $configItem
     * @return Config_Item_AvailableValue_Interface Текущий объект
     */
    public function setConfigItem(Config_Item_Interface $configItem);
}