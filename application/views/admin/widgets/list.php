<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<? if ($widgets->count() > 0): ?>
    <table class="striped sortable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Системное имя</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($widgets as $widget): ?>
                <tr>
                    <td><?= $widget->pk() ?></td>
                    <td><?= $widget->title ?></td>
                    <td><?= $widget->name ?></td>
                    <td>
                        <ul class="button-bar">

                            <li><a href="/admin/widgets/settings/<?= $widget->pk() ?>"><span class="icon" data-icon="z"></span>Настройки</a></li>
                            <li><a href="/admin/widgets/manage/<?= $widget->pk() ?>"><span class="icon" data-icon="z"></span>Управление</a></li>
                            <li><a href="/admin/widgets/edit/<?= $widget->pk() ?>"><span class="icon" data-icon="7"></span>Редактировать</a></li>
                            <li><a href="/admin/widgets/delete/<?= $widget->pk() ?>"><span class="icon" data-icon="x"></span>Удалить</a></li>
                        </ul>
                    </td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
<? else: ?>
    <p>На данный момент в системе нет ни одного виджета</p>
<? endif; ?>
    <ul class="button-bar">
        <li>
            <a href="/admin/widgets/add">
                <span class="icon large blue tooltip" title="Добавить виджет" data-icon="+"></span>Добавить виджет
            </a>
        </li>
    </ul>