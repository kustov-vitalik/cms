<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $good Model_Good */
?>
<fieldset>
    <legend>Удаление товара "<?= $good->getTitle() ?>"</legend>
    <p>Вы действительно хотите удалить товар "<?= $good->getTitle() ?>"</p>
    <form method="post" action="">
        <input type="submit" name="no" value="Нет" />
        <input type="submit" name="yes" value="Да" />
    </form>
    <? if(count($errors) > 0): ?>
    <? foreach ($errors as $error): ?>
    <p class="notice error"><?= $error ?></p>
    <? endforeach; ?>
    <? endif; ?>
</fieldset>