<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<fieldset>
    <legend>Назначение родительской страницы для страницы '<?= $page->getTitle() ?>'</legend>
    <form method="post" action="">
        <label>Родительская страница</label>
        <select name="parent_page_id" class="fancy">
            <option value="">Нет родительской страницы</option>
            <? foreach ($pages as $p): ?>
            <option value="<?= $p->pk() ?>"><?= $p->getTitle() ?></option>
            <? endforeach; ?>
        </select><br/>
        <input type="submit" value="Сохранить" />
    </form>
</fieldset>