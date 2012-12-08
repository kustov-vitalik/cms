<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $currentCatalog Model_Catalog */
/* @var $page Model_Page */
?>

<fieldset>
    <legend>Добавление нового каталога на страницу "<?= $page->getTitle() ?>"
        в каталог "<?= $currentCatalog->getTitle() ?>"</legend>
    <form method="post" action="/admin/catalog/addCatalog/<?= $page->pk() ?>:<?= $currentCatalog->pk() ?>">

        <label for="title">Название каталога</label>
        <input type="text" name="title" value="<?= Arr::get($data, 'title') ?>" />
        <? if(Arr::get($errors, 'title') != NULL): ?>
        <label for="error" class="notice error"><?= Arr::get($errors, 'title') ?></label>
        <? endif; ?>

        <input type="hidden" name="page_id" value="<?= $page->pk() ?>" />
        <input type="hidden" name="parent_catalog_id" value="<?= $currentCatalog->pk() ?>" />

        <br/>
        <input type="submit" value="Сохранить" />
    </form>
</fieldset>