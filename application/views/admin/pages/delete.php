<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form action="" method="post" >
    <label>Вы действительно хотите удалить страницу "<?= $page->getTitle() ?>"?</label>
    <br/><input type="submit" name="submit" value="Да" /><input type="submit" name="no" value="Нет" />
</form>

<? if(count($errors) > 0): ?>
<? foreach ($errors as $error): ?>
<?= $error ?>
<? endforeach; ?>
<? endif; ?>
