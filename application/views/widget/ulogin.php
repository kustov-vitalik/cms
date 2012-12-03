<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div>
    <? if (isset($content)): ?>
        <?= $content; ?>
    <? endif; ?>

    <? if (isset($errors)) : ?>
        <? foreach ($errors as $error): ?>
            <?= $error ?>
        <? endforeach; ?>
    <? endif; ?>
</div>