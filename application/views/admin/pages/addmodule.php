<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form action="/admin/pages/addmodule/<?= $page->pk() ?>" method="post" class="center">

    <label for="module_id">Модуль для страницы:</label>
    <select name="module_id" class="fancy">
        <? foreach ($modules as $module): ?>
        <option value="<?= $module->pk() ?>"><?= $module->title ?></option>
        <? endforeach; ?>
    </select>

    <br/>

    <input type="submit" name="submit" value="Сохранить" />

</form>