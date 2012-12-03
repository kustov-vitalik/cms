<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<form action="/admin/modules/edit/<?= Arr::get($data, 'module_id') ?>" method="post" class="center">
    <input type="hidden" name="module_id" value="<?= Arr::get($data, 'module_id') ?>" />

        <label class="col_3" for="title">Название модуля</label>
        <input type="text" name="title" size="30" value="<?= Arr::get($data, 'title') ?>"/>
        <? if(Arr::get($errors, 'title') != NULL): ?><br/><label class="notice error" for="title"><?= Arr::get($errors, 'title') ?></label><? endif; ?>

        <br/>

        <input type="submit" value="Сохранить" />


</form>