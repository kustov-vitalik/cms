<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<ul class="breadcrumbs alt1">
    <? foreach ($titles as $title): ?>
    <? if($title != NULL): ?>
    <li><a href=""><?= $title ?></a></li>
    <? endif; ?>
    <? endforeach; ?>
</ul>