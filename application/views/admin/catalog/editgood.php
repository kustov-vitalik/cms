<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $good Model_Good */

?>
<fieldset>
    <legend>Редактирование товара "<?= $good->getTitle() ?>"</legend>
    <form method="post" action="">
        <label for="title">Название товара</label>
        <input type="text" name="title" value="<?= $good->getTitle() ?>" />
        <? if(Arr::get($errors, 'title') != NULL): ?>
        <label for="error" class="notice error"><?= Arr::get($errors, 'title') ?></label>
        <? endif; ?>

        <input type="submit" value="Сохранить" />
    </form>
</fieldset>