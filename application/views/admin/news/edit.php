<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<form action="/admin/news/edit/<?= Arr::get($data, 'new_id') ?>" method="post" >

    <input type="hidden" name="page_id" value="<?= Arr::get($data, 'page_id') ?>" />
    <input type="hidden" name="new_id" value="<?= Arr::get($data, 'new_id') ?>" />

        <label class="col_3" for="title">Название новости</label>
        <input type="text" name="title" size="30" value="<?= Arr::get($data, 'title') ?>"/>
        <? if(Arr::get($errors, 'title') != NULL): ?><br/><label class="notice error" for="title"><?= Arr::get($errors, 'title') ?></label><? endif; ?>

        <br/>

        <label class="col_3" for="announce">Анонс новости</label>
        <textarea cols="80" rows="3" name="announce"><?= Arr::get($data, 'announce') ?></textarea>
        <? if(Arr::get($errors, 'announce') != NULL): ?><br/><label class="notice error" for="announce"><?= Arr::get($errors, 'announce') ?></label><? endif; ?>
        <br/>

        <label class="col_3" for="text">Текст новости</label>
        <textarea cols="80" rows="3" name="text"><?= Arr::get($data, 'text') ?></textarea>
        <? if(Arr::get($errors, 'text') != NULL): ?><br/><label class="notice error" for="text"><?= Arr::get($errors, 'text') ?></label><? endif; ?>

        <br/>

        <label class="col_3" for="date">Дата добавления новости</label>
        <input type="datetime" name="date" size="30" value="<?= Arr::get($data, 'date') ?>"/>
        <? if(Arr::get($errors, 'date') != NULL): ?><br/><label class="notice error" for="date"><?= Arr::get($errors, 'date') ?></label><? endif; ?>

        <br/>

        <input type="submit" value="Сохранить" />


</form>