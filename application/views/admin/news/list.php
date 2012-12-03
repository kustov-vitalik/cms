<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<? if ($news->count() > 0): ?>
    <table class="sortable striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название новости</th>
                <th>Дата создания</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($news as $new): ?>
                <tr>
                    <td><?= $new->pk() ?></td>
                    <td><?= $new->title ?></td>
                    <td><?= $new->date ?></td>
                    <td>
                        <ul class="button-bar">
                            <li><a href="/admin/news/edit/<?= $new->pk() ?>"><span class="icon" data-icon="7"></span>Редактировать</a></li>
                            <li><a href="/admin/news/delete/<?= $new->pk() ?>"><span class="icon" data-icon="x"></span>Удалить</a></li>
                        </ul>
                    </td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
<? else: ?>
    <p>На данный момент нет новостей</p>
<? endif; ?>
<ul class="button-bar">
    <li><a href="/admin/news/add/<?= $page->pk() ?>"><span class="icon large blue tooltip" title="Добавить Новость" data-icon="+"></span>Добавить новость</a></li>
</ul>