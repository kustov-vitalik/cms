<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
return array(
    'name'  => array(
        'not_empty'  => 'Поле ":field" должно быть заполнено',
        'min_length' => 'Поле ":field" должно содержать минимум 4 знака',
        'max_length' => 'Поле ":field" должно содержать максимум 255 знаков',
    ),
    'text'  => array(
        'not_empty' => 'Поле ":field" должно быть заполнено',
        'min_length' => 'Поле ":field" должно содержать минимум 12 знаков',
    ),
    'email' => array(
        'not_empty' => 'Поле ":field" должно быть заполнено',
        'email'     => 'Поле ":field" должно содержать корректный email-адрес',
    ),
    'theme' => array(
        'not_empty'  => 'Поле ":field" должно быть заполнено',
        'min_length' => 'Поле ":field" должно содержать минимум 3 знака',
        'max_length' => 'Поле ":field" должно содержать максимум 255 знаков',
    ),
);