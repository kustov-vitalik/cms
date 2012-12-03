<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<form action="/admin/pages/edit/<?= Arr::get($data, 'page_id') ?>" method="post" class="center">
    <input type="hidden" name="page_id" value="<?= Arr::get($data, 'page_id') ?>" />
    <label class="col_2" for="title">Заголовок страницы</label>
    <input type="text" name="title" size="30" value="<?= Arr::get($data, 'title') ?>" />
    <? if (Arr::get($errors, 'title') != NULL): ?><br/><label for="error" class="notice error"><?= Arr::get($errors, 'title'); ?></label><? endif; ?>

    <br/>

    <label class="col_2" for="url">URL страницы</label>
    <input type="text" name="url" size="30" value="<?= Arr::get($data, 'url') ?>" />
    <? if (Arr::get($errors, 'url') != NULL): ?><br/><label for="error" class="notice error"><?= Arr::get($errors, 'url'); ?></label><? endif; ?>

    <br/>

    <?= Form::checkbox('in_menu', 'on', Arr::get($data, 'in_menu')) ?>
    <label for="in_menu">Показывать в меню?</label>

    <input type="submit" value="Сохранить" />

</form>

