<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $page Model_Page */
/* @var $widget Model_Widget */
?>

<table class="sortable striped">
    <thead>
        <tr>
            <th>Название виджета</th>
            <th>Позиция виджета в шаблоне</th>
            <th>Позиция вывода</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($page->getWidgets() as $widget): ?>
        <tr>
            <td><?= $widget->getTitle() ?></td>
            <td><?= $widget->getPositionName() ?></td>
            <td><?= $widget->getSequenceOnPage($page) ?></td>
            <td>
                <ul class="button-bar">
                    <li><a href="/admin/widgets/managerelation/<?= $widget->pk() . ':' . $page->pk() ?>">Настройки для страницы</a></li>
                    <li><a href="/admin/pages/moveDownWidget/<?= $widget->pk() . ':' . $page->pk() ?>">Вниз</a></li>
                    <li><a href="/admin/pages/moveUpWidget/<?= $widget->pk() . ':' . $page->pk() ?>">Вверх</a></li>
                </ul>
            </td>
        </tr>
        <? endforeach; ?>
    </tbody>
</table>
