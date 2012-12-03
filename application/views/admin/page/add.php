<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<form action="/admin/page/add/<?= Arr::get($data, 'page_id') ?>" method="post">
    <input type="hidden" name="page_id" value="<?= Arr::get($data, 'page_id') ?>" />

        <label class="col_2" for="title">Заголовок материала</label>
        <input type="text" name="title" size="30" value="<?= Arr::get($data, 'title') ?>" />
        <? if(Arr::get($errors, 'title') != NULL): ?><br/><label for="error" class="notice error"><?= Arr::get($errors, 'title'); ?></label><? endif; ?>

        <br/>

        <label class="col_2" for="text">Текст материала</label>
        <textarea name="text" cols="80" rows="3"></textarea>
        <? if(Arr::get($errors, 'text') != NULL): ?><br/><label for="error" class="notice error"><?= Arr::get($errors, 'text'); ?></label><? endif; ?>

        <br/>

        <input type="submit" value="Сохранить" />&nbsp;&nbsp;<a href="#" onclick="history.go(-1);"><button>Назад</button></a>

</form>
