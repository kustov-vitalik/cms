<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
return array(
    'News'     => array(
        'name'            => 'News',
        'title'           => 'Последние новости',
        'type'            => 'page_widget',
        'enable'          => 1,
        'description'     => 'Настройки для виджета "Последние новости"',
        'defaultPosition' => 'left',
        'group'           => array(
            array(
                'name'            => 'limit',
                'title'           => 'Количество отображаемых новостей',
                'type'            => 'number',
                'value'           => 5,
                'description'     => 'Параметр задаёт количество отображаемых новостей в виджете',
                'availableValues' => array(
                ),
            ),
        )
    ),
    'MainMenu' => array(
        'name'            => 'MainMenu',
        'title'           => 'Главное меню',
        'type'            => 'page_widget',
        'enable'          => 1,
        'description'     => 'Настройки для виджета "Меню"',
        'defaultPosition' => 'header',
        'group'           => array(
            array(
                'name'            => 'orientation',
                'title'           => 'Ориентация меню',
                'type'            => 'string',
                'value'           => 'horizontal',
                'description'     => 'Параметр задаёт ориентацию меню',
                'availableValues' => array(
                    array('value' => 'vertical'),
                    array('value' => 'horizontal'),
                ),
            ),
        )
    ),
    'Search'   => array(
        'name'            => 'Search',
        'title'           => 'Поиск',
        'type'            => 'page_widget',
        'enable'          => 1,
        'description'     => 'Настройки для виджета "Поиск"',
        'defaultPosition' => 'right',
        'group'           => array(
            array(
                'name'            => 'button_enable',
                'title'           => 'Кнопка включена?',
                'type'            => 'string',
                'value'           => 'yes',
                'description'     => 'Параметр отвечает за отображение кнопки поиска',
                'availableValues' => array(
                    array('value' => 'yes'),
                    array('value' => 'no'),
                ),
            ),
        )
    ),
    'Banner'   => array(
        'name'            => 'Banner',
        'title'           => 'Баннер',
        'type'            => 'page_widget',
        'enable'          => 1,
        'description'     => 'Настройки для виджета "Баннер"',
        'defaultPosition' => 'right',
        'group'           => array(
            array(
                'name'            => 'banner_code',
                'title'           => 'Код баннера',
                'type'            => 'richtext',
                'value'           => '',
                'description'     => 'HTML-код баннера, который будет отображаться на страницах',
                'availableValues' => array(

                ),
            ),
        )
    ),
    'Ulogin'   => array(
        'name'            => 'Ulogin',
        'title'           => 'Быстрая регистрация/авторизация через соц. сети',
        'type'            => 'page_widget',
        'enable'          => 1,
        'description'     => 'Настройки для виджета "Ulogin" - улучшенного аналога Loginza',
        'defaultPosition' => 'right',
        'group'           => array(
            array(
                'name'            => 'type',
                'title'           => 'Тип отображения виджета',
                'type'            => 'string',
                'value'           => 'panel',
                'description'     => 'Параметр отвечает за тип отображения виджета Ulogin',
                'availableValues' => array(
                    array('value' => 'small'),
                    array('value' => 'panel'),
                    array('value' => 'window'),
                ),
            ),
        )
    ),
    'ArbitraryCode'   => array(
        'name'            => 'ArbitraryCode',
        'title'           => 'Виджет произвольного кода',
        'type'            => 'page_widget',
        'enable'          => 1,
        'description'     => 'Настройки для виджета "ArbitraryCode" - виджета произвольного кода',
        'defaultPosition' => 'left',
        'group'           => array(
            array(
                'name'            => 'code',
                'title'           => 'Произвольный HTML-код виджета',
                'type'            => 'text',
                'value'           => '',
                'description'     => 'Параметр отвечает за выводимый HTML-код на странице',
                'availableValues' => array(
                ),
            ),
        )
    ),
);