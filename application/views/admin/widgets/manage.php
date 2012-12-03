<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<? if ($pages->count() > 0): ?>

    <table class="sortable striped">
        <thead>
            <tr>
                <th>Виджет</th>
                <th>Связь</th>
                <th>Страница</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($pages as $page): ?>
                <tr>
                    <td><?= $widget->getTitle() ?></td>
                    <td>
                        <? if ($widget->has('pages', $page)): ?>
                            <a href="/admin/widgets/managerelation/<?= $widget->pk() . ':' . $page->pk() ?>"><button>Управление связью</button></a>
                        <? else: ?>
                            <a href="/admin/widgets/addrelation/<?= $widget->pk() . ':' . $page->pk() ?>"><button>Создать связь</button></a>
                        <? endif; ?>
                    </td>
                    <td><?= $page->getTitle() ?></td>
                    <td>
                        <ul class="button-bar">
<!--                            <li><a href="/admin/pages/edit/<?= $page->pk() ?>"><span class="icon" data-icon="7"></span>Редактировать</a></li>-->

                            <? if ($widget->has('pages', $page)): ?>
                            <li><a href="/admin/widgets/removerelation/<?= $widget->pk(). ':'. $page->pk() ?>"><span class="icon" data-icon="x"></span>Удалить связь</a></li>
                            <? endif; ?>
                        </ul>
                    </td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>

<? else: ?>
    <p class="notice warning">Нет ни одной страницы. Невозможно установить виджет</p>
<? endif; ?>
