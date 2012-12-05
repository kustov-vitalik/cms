<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $currentCatalog Model_Catalog */
/* @var $page Model_Page */
?>

<fieldset>
    <legend>Редактирование каталога "<?= $currentCatalog->getTitle() ?>"</legend>
    <form method="post" action="/admin/catalog/editCatalog/<?= $page->pk() ?>:<?= $currentCatalog->pk() ?>">

        <label for="title">Название каталога</label>
        <input type="text" name="title" value="<?= $currentCatalog->getTitle() ?>" />
        <? if(Arr::get($errors, 'title') != NULL): ?>
        <label for="error" class="notice error"><?= Arr::get($errors, 'title') ?></label>
        <? endif; ?>

        <br/>
        <input type="submit" value="Сохранить" />
    </form>
</fieldset>