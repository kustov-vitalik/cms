<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
interface Config_Interface {

    /**
     * GETTERS
     */


    /**
     * Получить системное имя группы настроек
     * @return string Системное имя группы настроек
     */
    public function getName();

    /**
     * Получить Название группы настроек
     * @return string Название группы настроек
     */
    public function getTitle();

    /**
     * Получить Описание группы настроек
     * @return string Описание группы настроек
     */
    public function getDescription();

    /**
     * Получить Тип группы настроек
     * @return string Тип группы настроек
     */
    public function getType();

    /**
     * Узнать включена ли группа настроек
     * @return boolen Description
     */
    public function isEnable();

    /**
     * Получить коллекцию настроек
     * @return Collection Коллекция настроек
     */
    public function getItems();

    /**
     * SETTERS
     */

    /**
     * Установить Системное имя группы настроек
     * @param string $name
     * @return Config_Interface Группа настроек
     */
    public function setName($name);

    /**
     * Установить Название группы настроек
     * @param string $title
     * @return Config_Interface Группа настроек
     */
    public function setTitle($title);

    /**
     * Установить Описание группы настроек
     * @param string $description
     * @return Config_Interface Группа настроек
     */
    public function setDescription($description);

    /**
     * Установить Тип группы настроек
     * @param string $type
     * @return Config_Interface Группа настроек
     */
    public function setType($type);

    /**
     * Включить группу настроек
     * @return Config_Interface Группа настроек
     */
    public function doEnable();

    /**
     * Выключить группу настроек
     * @return Config_Interface Группа настроек
     */
    public function doDisable();

    /**
     * Установить настройки
     * @param Config_Item_Collection $items
     * @return Config_Interface Группа настроек
     */
    public function setItems(Collection_Interface $items);
}