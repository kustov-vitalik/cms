<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $catalogs Collection */
/* @var $catalog Model_Catalog */
/* @var $page Model_Page */
/* @var $currentCatalog Model_Catalog */
/* @var $good Model_Good */
?>
<fieldset>
    <legend>Управление каталогами/товарами</legend>
<? if($currentCatalog->loaded()): ?>
<a href="/admin/catalog/list/<?= $page->pk() ?>:<?= $currentCatalog->getParentCatalog()->pk() ?>"><button><-- Назад</button></a>
<? endif; ?>

<fieldset>
    <legend>Каталоги</legend>
    <? if (!$catalogs->isEmpty()): ?>

        <table class="striped sortable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Заголовок</th>
                    <th>URL</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?
                $it = $catalogs->getIterator();
                $it->rewind();
                ?>
                <? while ($it->valid()): ?>
                    <? $catalog = $it->current() ?>
                    <tr>
                        <td><?= $catalog->pk() ?></td>
                        <td>
                            <a href="/admin/catalog/list/<?= $page->pk() ?>:<?= $catalog->pk() ?>">
                                <?= $catalog->getTitle() ?> (Товаров: <?= $catalog->getGoods()->count() ?>, Подкаталогов: <?= $catalog->getChildrenCatalogs()->count() ?>)
                            </a>
                        </td>
                        <td><?= $catalog->getName() ?></td>
                        <td>
                            <ul class="button-bar">
                                <li><a href="/admin/catalog/moveDownCatalog/<?= $page->pk() ?>:<?= $catalog->pk() ?>"><span class="icon tooltip" title="Переместить вниз" data-icon="|"></span></a></li>
                                <li><a href="/admin/catalog/moveUpCatalog/<?= $page->pk() ?>:<?= $catalog->pk() ?>"><span class="icon tooltip" title="Переместить вверх" data-icon="~"></span></a></li>
                                <li><a href="/admin/catalog/editCatalog/<?= $page->pk() ?>:<?= $catalog->pk() ?>"><span class="icon tooltip" title="Редактировать" data-icon="7"></span></a></li>
                                <li><a href="/admin/catalog/deleteCatalog/<?= $page->pk() ?>:<?= $catalog->pk() ?>"><span class="icon tooltip" title="Удалить" data-icon="x"></span></a></li>
                            </ul>
                        </td>
                    </tr>
                    <? $it->next() ?>
                <? endwhile; ?>
            </tbody>
        </table>

    <? else: ?>
        <p>На данный момент нет ни одного каталога</p>
    <? endif; ?>
</fieldset>


<fieldset>
    <legend>Товары</legend>
    <? if (!$currentCatalog->getGoods()->isEmpty()): ?>

        <table class="striped sortable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Заголовок</th>
                    <th>URL</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <? $it = $currentCatalog->getGoods()->getIterator(); ?>
                <? $it->rewind(); ?>
                <? while ($it->valid()): ?>
                    <? $good = $it->current() ?>
                    <tr>
                        <td><?= $good->pk() ?></td>
                        <td><?= $good->getTitle() ?></td>
                        <td><?= $good->getName() ?></td>
                        <td>
                            <ul class="button-bar">
                                <li><a href="/admin/catalog/moveDownGood/<?= $good->pk() ?>"><span class="icon tooltip" title="Переместить вниз" data-icon="|"></span></a></li>
                                <li><a href="/admin/catalog/moveUpGood/<?= $good->pk() ?>"><span class="icon tooltip" title="Переместить вверх" data-icon="~"></span></a></li>
                                <li><a href="/admin/catalog/editGood/<?= $good->pk() ?>"><span class="icon tooltip" title="Редактировать" data-icon="7"></span></a></li>
                                <li><a href="/admin/catalog/deleteGood/<?= $good->pk() ?>"><span class="icon tooltip" title="Удалить" data-icon="x"></span></a></li>
                            </ul>
                        </td>
                    </tr>
                    <? $it->next() ?>
                <? endwhile; ?>
            </tbody>
        </table>
    <? else: ?>
        <p>В каталоге на данный момент товаров нет</p>
    <? endif; ?>

</fieldset>



<ul class="button-bar">
    <li><a href="/admin/catalog/addCatalog/<?= $page->pk() ?>:<?= $currentCatalog->pk() ?>"><span class="icon large blue tooltip" title="Добавить каталог" data-icon="+"></span>Добавить каталог</a></li>
    <li><a href="/admin/catalog/addGood/<?= $page->pk() ?>:<?= $currentCatalog->pk() ?>"><span class="icon large blue tooltip" title="Добавить товар" data-icon="+"></span>Добавить товар</a></li>
</ul>

</fieldset>