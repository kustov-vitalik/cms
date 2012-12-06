<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $pages Model_Page */


?>
<? if ($pages->count() > 0): ?>
        <table class="striped sortable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Заголовок</th>
                    <th>URL</th>
                    <th>Модуль страницы</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <? foreach ($pages as $page): ?>
                    <tr>
                        <td><?= $page->pk() ?></td>
                        <td>
                            <? if (!$page->inMenu()) : ?>
                    <strike>
                    <? endif; ?>
                    <?= $page->title ?>
                    <? if (!$page->inMenu()) : ?>
                    </strike>
                <? endif; ?>


            </td>
            <td><?= $page->url ?></td>
            <td><?= $page->getModule()->getTitle() ?></td>
            <td>
                <ul class="button-bar">
                    <? if ($page->inMenu()): ?>
                        <li><a href="/admin/pages/showInMenuOff/<?= $page->pk() ?>"><span class="icon tooltip" title="Отключить показ в главном меню" data-icon="p"></span></a></li>
                    <? else: ?>
                        <li><a href="/admin/pages/showInMenuOn/<?= $page->pk() ?>"><span class="icon tooltip" title="Включить показ в главном меню" data-icon="m"></span></a></li>
                    <? endif; ?>
                    <li><a href="/admin/pages/moveDown/<?= $page->pk() ?>"><span class="icon tooltip" title="Переместить вниз" data-icon="|"></span></a></li>
                    <li><a href="/admin/pages/moveUp/<?= $page->pk() ?>"><span class="icon tooltip" title="Переместить вверх" data-icon="~"></span></a></li>
                    <li><a href="/admin/pages/manage/<?= $page->pk() ?>"><span class="icon tooltip" title="Модуль" data-icon="G"></span></a></li>
                    <li><a href="/admin/pages/widgets/<?= $page->pk() ?>"><span class="icon tooltip" title="Виджеты" data-icon="R"></span></a></li>
                    <li><a href="/admin/pages/edit/<?= $page->pk() ?>"><span class="icon tooltip" title="Редактировать" data-icon="7"></span></a></li>
                    <li><a href="/admin/pages/settings/<?= $page->pk() ?>"><span class="icon tooltip" title="Настройки" data-icon="Z"></span></a></li>
                    <li><a href="/admin/pages/delete/<?= $page->pk() ?>"><span class="icon tooltip" title="Удалить" data-icon="x"></span></a></li>
                </ul>
            </td>
            </tr>
        <? endforeach; ?>
        </tbody>
        </table>
    <? else: ?>
        <p>На данный момент в системе нет ни одной страницы</p>
    <? endif; ?>
    <ul class="button-bar">
        <li><a href="/admin/pages/add"><span class="icon large blue tooltip" title="Добавить страницу" data-icon="+"></span>Добавить страницу</a></li>
    </ul>
