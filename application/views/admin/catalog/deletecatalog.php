<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $page Model_Page */
/* @var $currentCatalog Model_Catalog */
?>
<fieldset>
    <legend>Удаление каталога "<?= $currentCatalog->getTitle() ?>"</legend>
    <p>Вы действительно хотите удалить каталог "<?= $currentCatalog->getTitle() ?>"</p>
    <form method="post" action="/admin/catalog/deleteCatalog/<?= $page->pk() ?>:<?= $currentCatalog->pk() ?>">
        <input type="submit" name="no" value="Нет" />
        <input type="submit" name="yes" value="Да" />
    </form>
    <? if(count($error) > 0): ?>
    <? foreach ($errors as $error): ?>
    <p class="notice error"><?= $error ?></p>
    <? endforeach; ?>
    <? endif; ?>
</fieldset>