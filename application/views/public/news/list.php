<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>

        .newarticle {
            margin: 5px 5px;
            padding: 15px;
            font-family: Verdana;
            background-color: #DDD;
            border-radius: 9px;
            -moz-border-radius: 9px;
            -webkit-border-radius: 9px;

        }

        .newstitle {
            background-color: #CCC;
            border-radius: 9px;
            -moz-border-radius: 9px;
            -webkit-border-radius: 9px;

            padding: 5px;
        }
</style>
<? if($news->count() > 0): ?>
<? foreach ($news as $new): ?>
<article class="newarticle">
    <header>
        <h3 class="newstitle"><?= $new->title ?></h3>
    </header>
    <p>
        <?= $new->announce ?>
    </p>

    <a class="readmore" href="/<?= $module->getPage()->getURL() ?>/show/<?= $new->pk() ?>"><button class="small">Подробнее...</button></a>

</article>
<? endforeach; ?>
<?= $pagination ?>
<? else: ?>
<p>Новостей пока нет</p>
<? endif; ?>
