<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form action="/admin/news/delete/<?= $new->pk() ?>" method="post">
    <input type="hidden" name="new_id" value="<?= $new->pk() ?>" />

    <label>Вы действительно хотите удалить новость "<?= $new->title ?>"?</label>

        <br/><input type="submit" name="submit" value="Да" />&nbsp;&nbsp;&nbsp;<input type="submit" value="Нет" name="no" />
</form>

