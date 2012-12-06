<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $page Model_Page */
/* @var $currentCatalog Model_Catalog */

?>
<fieldset>
    <legend>Добавление товара в каталог "<?= $currentCatalog->getTitle() ?>"</legend>
    <form method="post" action="/admin/catalog/addGood/<?= $page->pk() ?>:<?= $currentCatalog->pk() ?>">
        <input type="hidden" name="catalog_id" value="<?= $currentCatalog->pk() ?>" />
        <label>Название товара</label>
        <input type="text" name="title" value="<?= Arr::get($data, 'title') ?>" />
        <? if(Arr::get($errors, 'title') != NULL): ?>
        <label for="error" class="notice error"><?= Arr::get($errors, 'title') ?></label>
        <? endif; ?>

        <input type="submit" value="Сохранить" />
    </form>
</fieldset>