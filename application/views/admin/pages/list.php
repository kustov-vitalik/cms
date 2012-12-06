<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $pages Model_Page */
/* @var $page Model_Page */
?>
<? if (!$page->getChildrenPages()->isEmpty()): ?>
    <table class="">
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
            <?
            $it = $page->getChildrenPages()->getIterator();
            $it->rewind();
            ?>
            <? while ($it->valid()): ?>
                <? /* @var $p Model_Page */ ?>
                <? $p = $it->current(); ?>

                <tr>
                    <td><?= $p->pk() ?></td>
                    <td>
                        <? if (!$p->inMenu()) : ?>
                <strike>
                <? endif; ?>
                <?= $p->title ?>
                <? if (!$p->inMenu()) : ?>
                </strike>
            <? endif; ?>


        </td>
        <td><?= $p->getURL() ?></td>
        <td><?= $p->getModule()->getTitle() ?></td>
        <td>
            <ul class="button-bar">
                <? if ($p->inMenu()): ?>
                    <li><a href="/admin/pages/showInMenuOff/<?= $p->pk() ?>"><span class="icon tooltip" title="Отключить показ в главном меню" data-icon="p"></span></a></li>
                <? else: ?>
                    <li><a href="/admin/pages/showInMenuOn/<?= $p->pk() ?>"><span class="icon tooltip" title="Включить показ в главном меню" data-icon="m"></span></a></li>
                <? endif; ?>
                <li><a href="/admin/pages/moveDown/<?= $p->pk() ?>"><span class="icon tooltip" title="Переместить вниз" data-icon="|"></span></a></li>
                <li><a href="/admin/pages/moveUp/<?= $p->pk() ?>"><span class="icon tooltip" title="Переместить вверх" data-icon="~"></span></a></li>
                <li><a href="/admin/pages/createParent/<?= $p->pk() ?>"><span class="icon tooltip" title="Сделать страницу вложенной" data-icon="_"></span></a></li>
                <li><a href="/admin/pages/manage/<?= $p->pk() ?>"><span class="icon tooltip" title="Модуль" data-icon="G"></span></a></li>
                <li><a href="/admin/pages/widgets/<?= $p->pk() ?>"><span class="icon tooltip" title="Виджеты" data-icon="R"></span></a></li>
                <li><a href="/admin/pages/edit/<?= $p->pk() ?>"><span class="icon tooltip" title="Редактировать" data-icon="7"></span></a></li>
                <li><a href="/admin/pages/settings/<?= $p->pk() ?>"><span class="icon tooltip" title="Настройки" data-icon="Z"></span></a></li>
                <li><a href="/admin/pages/delete/<?= $p->pk() ?>"><span class="icon tooltip" title="Удалить" data-icon="x"></span></a></li>
                <li><a href="/admin/pages/add/<?= $p->pk() ?>"><span class="icon blue tooltip" title="Добавить вложенную страницу" data-icon="+"></span></a></li>
            </ul>
        </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="4">
                <?= View::factory('admin/pages/list', array('page' => $p)); ?>
            </td>
        </tr>

        <? $it->next(); ?>
    <? endwhile; ?>
    </tbody>
    </table>
<? else: ?>
    <p>Вложенных страниц нет</p>
<? endif; ?>

<? if ($page->pk() == NULL): ?>
    <a href="/admin/pages/add/"><span class="icon blue large tooltip" title="Добавить страницу" data-icon="+"></span></a>
<? endif; ?>
