<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $page Model_Page */
?>
<form method="post" action="/<?= $page->getURL() ?>">

    <label for="name">Ваше имя</label>
    <input type="text" name="name" value="<?= Arr::get($data, 'name') ?>" />
    <label for="error"><?= Arr::get($errors, 'name') ?></label>

    <br/>

    <label for="email">Ваше Email</label>
    <input type="email" name="email" value="<?= Arr::get($data, 'email') ?>" />
    <label for="error"><?= Arr::get($errors, 'email') ?></label>

    <br/>

    <label for="theme">Тема сообщения</label>
    <input type="text" name="theme" value="<?= Arr::get($data, 'theme') ?>" />
    <label for="error"><?= Arr::get($errors, 'theme') ?></label>

    <br/>

    <label for="text">Текст сообщения</label>
    <textarea name="text" cols="25" rows="5"><?= Arr::get($data, 'text') ?></textarea>
    <label for="error"><?= Arr::get($errors, 'text') ?></label>

    <br/>

    <input type="hidden" name="page_id" value="<?= $page->pk() ?>" />
    <input type="submit" value="Отправить" />

</form>