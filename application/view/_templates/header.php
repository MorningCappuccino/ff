<!doctype html>
<html>
<head>
    <title>HUGE</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="data:;base64,=">
    <!-- <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/style.css"> -->
    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/screen.css">
    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/media.css">

    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/star-rating.css" >

    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/fileinput.min.css" >

    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/bootstrap-datepicker.css" >

    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/jquery.fancybox.min.css" >

    <script src='<?php echo Config::get('URL') ?>js/jquery-2.0.0.js'></script>
    <script src='<?php echo Config::get('URL') ?>js/bootstrap.js'></script>
    <script src='<?php echo Config::get('URL') ?>js/star-rating.js'></script>
    <script src='<?php echo Config::get('URL') ?>js/fileinput.min.js'></script>
    <script src='<?php echo Config::get('URL') ?>js/bootstrap-datepicker.js'></script>


</head>
<body>
<div class="container fp-header">
    <div class="row">
        <div class="col-lg-12">
            <!-- <nav class="navbar navbar-default fp-nav"> -->
              <!-- <div class="container-fluid"> -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav fp-nav">
                        <!-- <li <?php if (View::checkForActiveController($filename, "index")) { echo ' class="active" '; } ?> >
                            <a href="<?php echo Config::get('URL'); ?>index/index">Главная</a>
                        </li> -->

                        <li <?php if (View::checkForActiveController($filename, "cinema")) { echo ' class="active" '; } ?> >
                            <a href="<?php echo Config::get('URL'); ?>cinema/allCinemas">Кинотеатры</a>
                        </li>

                        <li <?php if (View::checkForActiveController($filename, "allFilms")) { echo ' class="active" '; } ?> >
                            <a href="<?php echo Config::get('URL'); ?>film/allfilms">Фильмы</a>
                        </li>

                        <li <?php if (View::checkForActiveController($filename, "allFestivals")) { echo ' class="active" '; } ?> >
                            <a href="<?php echo Config::get('URL'); ?>event/allfestivals">Фестивали</a>
                        </li>

                        <?php if (Session::userIsLoggedIn()) { ?>

                            <!-- <li <?php if (View::checkForActiveController($filename, "note")) { echo ' class="active" '; } ?> >
                                <a href="<?php echo Config::get('URL'); ?>note/index">My Notes</a>
                            </li> -->

                            <?php if (Session::get("user_account_type") == 7) : ?>
                            <li <?php if (View::checkForActiveController($filename, "profile")) { echo ' class="active" '; } ?> >
                                <a href="<?php echo Config::get('URL'); ?>profile/index">Профили</a>
                            </li>
                            <?php endif ?>

                            <?php } else { ?>
                            <!-- for not logged in users -->
                            <li <?php if (View::checkForActiveControllerAndAction($filename, "login/index")) { echo ' class="active" '; } ?> >
                                <a href="<?php echo Config::get('URL'); ?>login/index">Войти</a>
                            </li>
                            <li <?php if (View::checkForActiveControllerAndAction($filename, "register/index")) { echo ' class="active" '; } ?> >
                                <a href="<?php echo Config::get('URL'); ?>register/index">Регистрация</a>
                            </li>
                            <?php } ?>


                            <!-- Account -->
                            <?php if (Session::userIsLoggedIn()) : ?>
                                <li account <?php if (view::checkforactivecontroller($filename, "user")) { echo ' class="active" '; } ?> >
                                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Мой аккаунт<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo Config::get('URL'); ?>user/index">Мой аккаунт</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo Config::get('URL'); ?>user/changeUserRole">Изменить тип аккаунта</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo Config::get('URL'); ?>user/editAvatar">Изменить аватар</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo Config::get('URL'); ?>user/editusername">Изменить имя</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo Config::get('URL'); ?>user/edituseremail">Изменить email</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo Config::get('URL'); ?>user/changePassword">Изменить пароль</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo Config::get('URL'); ?>login/logout">Выйти</a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- Admin -->
                                <?php if (Session::get("user_account_type") == 7) : ?>
                                        <li <?php if (View::checkForActiveController($filename, "madmin")) {
                                            echo ' class="active" ';
                                        } ?> >
                                        <a href="<?php echo Config::get('URL'); ?>madmin/">Admin</a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>

                        </ul>


            </div><!-- /.navbar-collapse -->

        </div>
    </div>
</div>

<div class="container wrapper">
