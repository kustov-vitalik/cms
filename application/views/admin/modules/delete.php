<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form action="/admin/modules/delete" method="post">
    <input type="hidden" name="module_id" value="<?= $module->pk() ?>" />

    <label>Вы действительно хотите удалить модуль "<?= $module->title ?>"?</label>
    <? if ($pages->count() > 0): ?>
        <p>Вместе с ним будут удалены страницы:</p>
        <ul class="checks">
            <? foreach ($pages as $page): ?>
                <li><?= $page->title ?></li>
            <? endforeach; ?>
        </ul>
    <? endif; ?>
        <br/><input type="submit" name="submit" value="Да" />&nbsp;&nbsp;&nbsp;<input type="submit" value="Нет" name="no" />
</form>

