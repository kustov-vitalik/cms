<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<? foreach ($news as $new): ?>
<div>
    <h5><a href="/news/show/<?= $new->pk() ?>"><?= $new->title ?></a></h5>
</div>
<? endforeach; ?>
