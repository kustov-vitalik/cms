<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<form action="/<?= $module->getPage()->url ?>" method="get">
    <input type="search" name="query" value="<?= $query ?>" />
</form>
<? if(isset($hits)): ?>
<? foreach ($hits as $hit): ?>
<p><?



    if ($hit instanceof Zend_Search_Lucene_Search_QueryHit)
    {
        Zend_Debug::dump(($hit->getDocument()->getFieldNames()));
    }

?></p>
<? endforeach; ?>
<? endif; ?>