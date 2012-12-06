<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<? if($modules->count() > 0): ?>
<?= Form::open('/admin/pages/add/' . $parentPage->pk(), array('method' => 'post', 'class' => 'center')); ?>
<?= Form::label('title', 'Заголовок страницы', array('class' => 'col_2')); ?>
<?= Form::input('title', Arr::get($data, 'title'), array('size' => '30')); ?>

<? if(Arr::get($errors, 'title') != NULL): ?>
    <?= Form::label('error', Arr::get($errors, 'title'), array('class' => 'notice error')); ?>
<? endif; ?>

<br/>

<?= Form::label('url', 'URL страницы', array('class' => 'col_2')); ?>
<?= Form::input('url', Arr::get($data, 'url'), array('size' => '30')); ?>
<? if(Arr::get($errors, 'url') != NULL): ?>
<?= Form::label('error', Arr::get($errors, 'url'), array('class' => 'notice error')); ?>
<? endif; ?>


<br/>

<?= Form::label('module_id', 'Модуль для страницы', array('class' => 'col_2')) ?>
<select name="module_id" class="fancy">
    <? foreach ($modules as $module): ?>
    <option value="<?= $module->pk() ?>"><?= $module->getTitle() ?></option>
    <? endforeach; ?>
</select>

<br/>

<?= Form::checkbox('in_menu', 'on', FALSE)  ?>
<label for="in_menu">Показывать в главном меню?</label>

<br/>
<input type="hidden" name="parent_page_id" value="<?= $parentPage->pk() ?>" />
<?= Form::submit('submit', 'Сохранить'); ?>
<?= Form::close(); ?>

<? else: ?>
<p class="notice warning col_9 center">Вы не можете добавить страницу, потому как в системе не зарегистрировано ни одного модуля</p>
<? endif; ?>
