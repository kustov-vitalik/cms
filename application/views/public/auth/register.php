<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $page Model_Page */
?>
<form method="post" action="/<?= $page->getURL() ?>/register">

    <label for="username">Ваше имя</label>
    <input type="text" name="username" value="<?= Arr::get($data, 'username') ?>" />
    <label for="error"><?= Arr::get($errors, 'username') ?></label>

    <br/>

    <label for="email">Ваше Email</label>
    <input type="email" name="email" value="<?= Arr::get($data, 'email') ?>" />
    <label for="error"><?= Arr::get($errors, 'email') ?></label>

    <br/>

    <label for="password">Тема сообщения</label>
    <input type="password" name="password" value="<?= Arr::get($data, 'password') ?>" />
    <label for="error"><?= Arr::get($errors, 'password') ?></label>

    <br/>

    <input type="hidden" name="page_id" value="<?= $page->pk() ?>" />
    <input type="submit" value="Отправить" />

</form>