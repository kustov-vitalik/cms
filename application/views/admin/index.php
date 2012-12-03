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
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
        <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <script type="text/javascript" src="/media/kickstart/js/prettify.js"></script>                                   <!-- PRETTIFY -->
        <script type="text/javascript" src="/media/kickstart/js/kickstart.js"></script>                                  <!-- KICKSTART -->
        <link rel="stylesheet" type="text/css" href="/media/kickstart/css/kickstart.css" media="all" />                  <!-- KICKSTART -->
        <link rel="stylesheet" type="text/css" href="/media/kickstart/style.css" media="all" />                          <!-- CUSTOM STYLES -->
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
    </head>
    <body>
        <a id="top-of-page"></a>
        <div id="wrap" class="clearfix">

            <!-- ===================================== END HEADER ===================================== -->


            <ul class="menu">
                <li><a href="/admin/pages"><span class="icon" data-icon="."></span>Страницы</a></li>
                <li><a href="/admin/modules"><span class="icon" data-icon="G"></span>Модули</a></li>
                <li><a href="/admin/widgets"><span class="icon" data-icon="R"></span>Виджеты</a>

                </li>
                <li><a href="/admin/settings"><span class="icon" data-icon="Z"></span>Настройки</a>
                <li><a href="/admin/auth/logout"><span class="icon" data-icon="A"></span>Выход</a>
            </ul>

            <?= Manager::Instance()->getManagerContent()->getBreadCrumbs() ?>

            <?= $content ?>


            <!--ADD YOUR HTML ELEMENTS HERE

                    Example: 2 Columns
                <div class="col_12">
                <h1 class="center">
                    <span class="icon" style="font-size:400px;text-shadow: 0px 3px 2px rgba(0,0,0,0.3);color:#efefef;" data-icon="F"></span><br />
                    This example is blank</h1>
                <h3 style="color:#ccc;margin-bottom:40px;" class="center">Add some HTML KickStart Elements to see the magic happen</h3>
            </div>-->

            <!-- ===================================== START FOOTER ===================================== -->
        </div>

        <!--        </div> END WRAP -->

        <?php //echo View::factory('profiler/stats') ?>

        <? if(Manager_Content::Instance()->isJsText()): ?>
        <script><?= Manager_Content::Instance()->getJsText() ?></script>
        <? endif; ?>
    </body>
</html>