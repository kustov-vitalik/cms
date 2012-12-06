<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $breadCrumbs BreadCrumbs */
/* @var $item BreadCrumbs_Item */
?>
<ul class="breadcrumbs alt1">
    <? if(!$breadCrumbs->getItems()->isEmpty()): ?>
    <? $it = $breadCrumbs->getItems()->getIterator(); $it->rewind(); ?>
    <? while ($it->valid()): ?>
    <? $item = $it->current() ?>
    <li><a href="<?= $item->getUrl() ?>"><?= $item->getTitle() ?></a></li>
    <? $it->next() ?>
    <? endwhile; ?>
    <? endif; ?>
</ul>