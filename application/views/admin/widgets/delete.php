<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<form action="/admin/widgets/delete/<?= Arr::get($data, 'widget_id') ?>" method="post" class="center">

    <p>Вы действительно хотите удалить виджет "<?= Arr::get($data, 'title'); ?>"?</p>

        <input type="submit" name="submit" value="Да" /><input type="submit" name="no" value="Нет" />


</form>