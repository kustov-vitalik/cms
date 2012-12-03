<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<form action="/admin/modules/add" method="post" class="center">

        <label class="col_3" for="title">Название модуля</label>
        <input type="text" name="title" size="30" value="<?= Arr::get($data, 'title') ?>"/>
        <? if(Arr::get($errors, 'title') != NULL): ?><br/><label class="notice error" for="title"><?= Arr::get($errors, 'title') ?></label><? endif; ?>

        <br/>

        <label class="col_3" for="name">Системное имя модуля</label>
        <select name="name" class="fancy">
            <? foreach ($modules as $module): ?>
            <option value="<?= $module ?>"><?= $module ?></option>
            <? endforeach; ?>
        </select>
        <? if(Arr::get($errors, 'name') != NULL): ?><br/><label class="notice error" for="name"><?= Arr::get($errors, 'name') ?></label><? endif; ?>

        <br/>

        <input type="submit" value="Сохранить" />


</form>