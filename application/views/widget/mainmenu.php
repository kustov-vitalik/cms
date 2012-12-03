<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
    .menu {
        float: left;
        font: bold 12px Arial, Helvetica, Sans-serif;
        border: 1px solid #121314;
        border-top: 1px solid #2b2e30;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        overflow: hidden;
    }
    .menu ul {
        margin:0;
        padding:0;
        list-style:none;
    }
    .menu ul li{
        float:left;
    }
    .menu ul li a {
        float: left;
        color:#d4d4d4;
        padding: 10px 20px;
        text-decoration:none;
        background:#3C4042;
        background: -webkit-gradient( linear, left bottom, left top, color-stop(0.09, rgb(59,63,65)), color-stop(0.55, rgb(72,76,77)), color-stop(0.78, rgb(75,77,77)) );
        background: -moz-linear-gradient( center bottom, rgb(59,63,65) 9%, rgb(72,76,77) 55%, rgb(75,77,77) 78% );
        background: -o-linear-gradient( center bottom, rgb(59,63,65) 9%, rgb(72,76,77) 55%, rgb(75,77,77) 78% );
        box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset, 0 0 5px rgba(0, 0, 0, 0.1) inset;
        border-left: 1px solid rgba(255, 255, 255, 0.05);
        border-right: 1px solid rgba(0,0,0,0.2);
        text-shadow: 0 -1px 1px rgba(0, 0, 0, 0.6);
    }
    .menu li ul{
        background:#3C4042;
        background-image: -webkit-gradient( linear, left bottom, left top, color-stop(0.09, rgb(77,79,79)), color-stop(0.55, rgb(67,70,71)), color-stop(0.78, rgb(69,70,71)) );
        background-image: -moz-linear-gradient( center bottom, rgb(77,79,79) 9%, rgb(67,70,71) 55%, rgb(69,70,71) 78% );
        background-image: -o-linear-gradient( center bottom, rgb(77,79,79) 9%, rgb(67,70,71) 55%, rgb(69,70,71) 78% );
        border-radius: 0 0 10px 10px;
        -moz-border-radius: 0 0 10px 10px;
        -webkit-border-radius: 0 0 10px 10px;
        left: -999em;
        position: absolute;
        width: 160px;
        z-index: 9999;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.4) inset;
        -moz-box-shadow: 0 0 15px rgba(0, 0, 0, 0.4) inset;
        -webkit-box-shadow: 0 0 15px rgba(0, 0, 0, 0.4) inset;
        border: 1px solid rgba(0, 0, 0, 0.5);
        margin: 35px 0 0;
    }
    .menu li ul a {
        background: none;
        border: 0 none;
        margin-right: 0;
        width: 120px;
        box-shadow: none;
        -moz-box-shadow: none;
        -webkit-box-shadow: none;
        border-bottom: 1px solid transparent;
        border-top: 1px solid transparent;
    }
    .menu ul li a:hover,
    .menu ul li:hover > a {
        color: #252525;
        background:#3C4042;
        background: -webkit-gradient( linear, left bottom, left top, color-stop(0.09, rgb(77,79,79)), color-stop(0.55, rgb(67,70,71)), color-stop(0.78, rgb(69,70,71)) );
        background: -moz-linear-gradient( center bottom, rgb(77,79,79) 9%, rgb(67,70,71) 55%, rgb(69,70,71) 78% );
        background: -o-linear-gradient( center bottom, rgb(77,79,79) 9%, rgb(67,70,71) 55%, rgb(69,70,71) 78% );
        text-shadow: 0 1px 0 rgba(255, 255, 255, 0.2), 0 -1px #000;

    }
    .menu li ul a:hover,
    .menu ul li li:hover > a  {
        color: #2c2c2c;
        background: #5C9ACD;
        background: -webkit-gradient( linear, left bottom, left top, color-stop(0.17, rgb(61,111,177)), color-stop(0.51, rgb(80,136,199)), color-stop(1, rgb(92,154,205)) );
        background: -moz-linear-gradient( center bottom, rgb(61,111,177) 17%, rgb(80,136,199) 51%, rgb(92,154,205) 100% );
        background: -o-linear-gradient( center bottom, rgb(61,111,177) 17%, rgb(80,136,199) 51%, rgb(92,154,205) 100% );
        border-bottom: 1px solid rgba(0,0,0,0.6);
        border-top: 1px solid #7BAED9;
        text-shadow: 0 1px rgba(255, 255, 255, 0.3);
    }
    .menu li:hover ul {
        left: auto;
    }
    .menu li li ul {
        margin: -1px 0 0 160px;
        -webkit-border-radius: 0 10px 10px 10px;
        -moz-border-radius: 0 10px 10px 10px;
        border-radius: 0 10px 10px 10px;
        visibility:hidden;
    }
    .menu li li:hover ul {
        visibility:visible;
    }
    .menu ul ul li:last-child > a {
        -moz-border-radius:0 0 10px 10px;
        -webkit-border-radius:0 0 10px 10px;
        border-radius:0 0 10px 10px;
    }
    .menu ul ul ul li:first-child > a {
        -moz-border-radius:0 10px 0 0;
        -webkit-border-radius:0 10px 0 0;
        border-radius:0 10px 0 0;
    }
    .menu .current a{
        color: red;
    }

    .vertical ul {
        text-align: center;
    }
    .vertical ul li {
        width: 160px;
        float: none;
    }
    .vertical li ul {
        margin: 120px 0 0 161px;
    }
    .vertical ul li a:hover,
    .vertical ul li:hover > a {
        width: 120px;
    }
    .vertical ul li a {

        width: 120px;

    }
</style>
<? if ($pages->count() > 0): ?>
    <div class="menu">
        <ul>
            <? foreach ($pages as $page): ?>
                <li <? if ($page->isCurrent()): ?>class="current"<? endif; ?>><a href="/<?= $page->url ?>"><?= $page->title ?></a></li>
                <? endforeach; ?>

        </ul>
    </div>
<? else: ?>

<? endif; ?>
