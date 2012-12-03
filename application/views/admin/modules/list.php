<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<? if ($modules->count() > 0): ?>
    <table class="sortable striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Системное имя</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($modules as $module): ?>
                <tr>
                    <td><?= $module->pk() ?></td>
                    <td><?= $module->title ?></td>
                    <td><?= $module->name ?></td>
                    <td>
                        <ul class="button-bar">
                            <li><a href="/admin/modules/edit/<?= $module->pk() ?>"><span class="icon" data-icon="7"></span>Редактировать</a></li>
                            <li><a href="/admin/modules/settings/<?= $module->pk() ?>"><span class="icon" data-icon="z"></span>Управление</a></li>
                            <li><a href="/admin/modules/delete/<?= $module->pk() ?>"><span class="icon" data-icon="x"></span>Удалить</a></li>
                        </ul>
                    </td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
<? else: ?>
    <p>На данный момент в системе нет ни одного модуля</p>
<? endif; ?>
<ul class="button-bar">
    <li><a href="/admin/modules/add"><span class="icon large blue tooltip" title="Добавить модуль" data-icon="+"></span>Добавить модуль</a></li>
</ul>