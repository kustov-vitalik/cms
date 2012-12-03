<?php defined('SYSPATH') or die('No direct script access.'); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Вход в панель администратора</title>
        <meta charset="UTF-8">
        <link href="/media/application/admin/auth/screen.css" rel="stylesheet" type="text/css" />
        <script src="/media/js/jquery/jquery-1.7.1.js"></script>
        <script src="/media/application/admin/auth/script.js"></script>
    </head>
    <body>

        <div id="cont">
            <div class="box lock"> </div>
            <div id="loginform" class="box form">
                <h2>Обязательная авторизация <a href="" class="close">Закрыть</a></h2>
                <div class="formcont">
                    <fieldset id="signin_menu">
                        <span class="message">Пожалуйста, введите верные данные</span>
                        <form method="POST" id="signin" action="/admin/auth/login">
                            <p>
                                <label for="username">Логин</label>
                                <input id="login" name="username" value="<?= Arr::get($data, 'login') ?>" title="Login" class="required" tabindex="4" type="text">
                            </p>
                            <p>
                                <label for="password">Пароль</label>
                                <input id="password" name="password" value="<?= Arr::get($data, 'password') ?>" title="password" class="required" tabindex="5" type="password">
                            </p>
                            <p>
                                <label for="remember">Запомнить меня&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="remember" />
                                </label>
                            </p>
                            <p class="clear"></p>

                            <p class="remember">
                                <input id="signin_submit" value="Войти" tabindex="6" type="submit">
                                <input id="cancel_submit" value="Отмена" tabindex="7" type="button">
                            </p>

                        </form>
                    </fieldset>
                </div>
                <div class="formfooter"></div>
            </div>
        </div>
        <!-- Begin Full page background technique -->
        <div id="bg">
            <div>
                <table cellspacing="0" cellpadding="0">
                    <tr>
                        <td><img src="/media/application/admin/auth/images/bg.jpg" alt=""/> </td>
                    </tr>
                </table>
            </div>
        </div>

        <?php if ($errors != NULL): ?>
            <?php foreach ($errors as $error): ?>
                <?php echo $error; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </body>
</html>