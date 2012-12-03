<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form method="get" action="/<? /* @var $page Model_Page */ echo $page->url ?>">
    <input type="search" placeholder="Искать" name="query" />
    <? if($button_enable == 'yes'): ?>
    <input type="submit" value="Искать" />
    <? else: ?>
    <? endif; ?>
</form>