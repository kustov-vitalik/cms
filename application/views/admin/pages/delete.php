<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form action="/admin/pages/delete" method="post" >
    <input type="hidden" name="page_id" value="<?= $page->pk() ?>" />

    <label>Вы действительно хотите удалить страницу "<?= $page->title ?>"?</label>
    <br/><input type="submit" name="submit" value="Да" />&nbsp;&nbsp;&nbsp;<input type="submit" name="no" value="Нет" />
</form>


