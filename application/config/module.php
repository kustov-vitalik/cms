<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
return array(
    /**
     * Модуль "Текстовая страница"
     */
    'Page'     => array(
        'name'        => 'Page',
        'title'       => 'Настройки модуля "Текстовая страница"',
        'type'        => 'module_default',
        'enable'      => 1,
        'description' => 'Эта группа настроек отвечает за работу модуля "Текстовая страница"',
        'group'       => array(
        )
    ),
    /**
     * Модуль "Новости"
     */
    'News'     => array(
        'name'        => 'News',
        'title'       => 'Настройки модуля "Публикации"',
        'type'        => 'module_default',
        'enable'      => 1,
        'description' => 'Эта группа настроек отвечает за работу модуля "Публикации"',
        'group'       => array(
            array(
                'name'            => 'limit',
                'title'           => 'Количество материалов на странице',
                'type'            => 'number',
                'value'           => 5,
                'description'     => 'Этот параметр отвечает за количество
                    отображаемых публикаций на странице',
                'availableValues' => array(
                ),
            ),
            array(
                'name'            => 'title_is_link',
                'title'           => 'Заголовок в виде ссылки?',
                'type'            => 'string',
                'value'           => 'off',
                'description'     => 'Параметр отвечает за то,
                    будет ли заголовок публикации отображаться в виде ссылки',
                'availableValues' => array(
                    array('value' => 'on'),
                    array('value' => 'off'),
                ),
            ),
        )
    ),
    /**
     * Модуль "Поиск"
     */
    'Search'   => array(
        'name'  => 'Search',
        'title' => 'Настройки модуля "Поиск"',
        'type'  => 'module_default',
        'enable'      => 1,
        'description' => 'Эта группа настроек отвечает за работу модуля "Поиск"',
        'group' => array(
            array(
                'name'            => 'results_per_page',
                'title'           => 'Количество материалов на странице выдачи',
                'type'            => 'number',
                'value'           => 5,
                'description'     => 'Параметр отвечает за количество
                    материалов в выдаче на странице',
                'availableValues' => array(
                ),
            ),
        )
    ),
    /**
     * Модуль "Обратная связь"
     */
    'Feedback' => array(
        'name'  => 'Feedback',
        'title' => 'Настройки модуля "Обратная связь"',
        'type'  => 'module_default',
        'enable'      => 1,
        'description' => 'Эта группа настроек отвечает за работу модуля "Обратная связь"',
        'group' => array(
            array(
                'name'            => 'response_text',
                'title'           => 'Текст ответа отправителю',
                'type'            => 'richtext',
                'value'           => '<p><strong>{$^NAME^$}</strong>, благодарим Вас за обращение</p>',
                'description'     => 'Параметр отвечает за то, какое сообщение
                    получит пользователь после успешной отправки формы обратной связи.
                    Обратите внимание, что параметр <strong>{$^NAME^$}</strong>
                    будет автоматически заменен
                    на имя, которое пользователь укажет в поле формы "Ваше имя"',
                'availableValues' => array(
                ),
            )
        )
    ),
    /**
     * Модуль "Каталог товаров"
     */
    'Catalog' => array(
        'name'  => 'Catalog',
        'title' => 'Настройки модуля "Каталог товаров"',
        'type'  => 'module_default',
        'enable'      => 1,
        'description' => 'Эта группа настроек отвечает за работу модуля "Каталог товаров"',
        'group' => array(
            array(
            )
        )
    ),
);