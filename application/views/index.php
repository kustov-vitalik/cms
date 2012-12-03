<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" >
        <title><?= $title ?></title>
        <meta name="description" content="" />
        <? if (isset($scripts)): ?>
            <? foreach ($scripts as $script): ?>
                <script src="<?= $script ?>"></script>
            <? endforeach; ?>
        <? endif; ?>
        <? if (isset($styles)): ?>
            <? foreach ($styles as $style): ?>
                <link rel="stylesheet" href="<?= $style ?>" />
            <? endforeach; ?>
        <? endif; ?>
                <style>
                    body{
                        background-color: #666666;
                    }
                    #wrap{
                        margin: 0 auto;
                        padding: 10px;
                        width: 1200px;
                        background-color: #444444;
                        color: #fcf8e3;
                        border-radius: 10px;
                        -moz-border-radius: 10px;
                        -webkit-border-radius: 10px;

                        box-shadow: 0px 0px 20px #fafafa, 0px 0px 40px rgba(0, 200, 0, 0.4);
                        -moz-box-shadow: 0px 0px 20px #fafafa, 0px 0px 40px rgba(0, 200, 0, 0.4);
                        -webkit-box-shadow: 0px 0px 20px #fafafa, 0px 0px 40px rgba(0, 200, 0, 0.4);

                    }
                    a{
                        color: #fafafa;
                    }
                    section, header, footer{
                        display: block;
                    }

                    #leftColumn{
                        float: left;
                        width: 240px;
                        clear: both;
                        padding: 3px;
                        border: 1px #fcf8e3 solid;
                    }

                    #centerColumn{
                        width: 692px;
                        float: left;
                        padding: 5px;
                        border: 1px #fcf8e3 solid;
                    }

                    #rightColumn{
                        float: right;
                        width: 240px;
                        padding: 3px;
                        border: 1px #fcf8e3 solid;
                    }

                    #wrap > footer, #wrap > header{
                        border: 1px #fcf8e3 solid;
                    }



                </style>
    </head>
    <body>
        <div id="wrap">
            <header>
                <?= ____('header') ?>
            </header>
            <section id="mainBlock">
                <section id="leftColumn">
                    <?= ____('left') ?>
                </section>
                <section id="centerColumn">
                    <?= ____('center') ?>
                    <?= ____('module') ?>
                </section>
                <section id="rightColumn">
                    <?= ____('right') ?>
                </section>
                <div style="clear: both;"></div>
            </section>
            <footer>
                <?= ____('footer') ?>
                <?= ProfilerToolbar::render(); ?>
                <? //= View::factory('profiler/stats'); ?>
            </footer>
        </div>
    </body>
</html>