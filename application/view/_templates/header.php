<!doctype html>
<html>
<head>
    <title>HUGE</title>
    <meta charset="utf-8">
    <link rel="icon" href="data:;base64,=">
    <!-- <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/style.css"> -->
    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/screen.css">
    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/media.css">

    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/star-rating.css" >

    <script src='<?php echo Config::get('URL') ?>js/jquery-2.0.0.js'></script>
    <script src='<?php echo Config::get('URL') ?>js/star-rating.js'></script>


</head>
<body>
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-default">
                  <div class="container-fluid">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                            <li <?php if (View::checkForActiveController($filename, "index")) { echo ' class="active" '; } ?> >
                                <a href="<?php echo Config::get('URL'); ?>index/index">Index</a>
                            </li>
                            <li <?php if (View::checkForActiveController($filename, "profile")) { echo ' class="active" '; } ?> >
                                <a href="<?php echo Config::get('URL'); ?>profile/index">Profiles</a>
                            </li>
                            <li <?php if (View::checkForActiveController($filename, "allFilms")) { echo ' class="active" '; } ?> >
                                <a href="<?php echo Config::get('URL'); ?>film/allfilms">Все фильмы</a>
                            </li>
                            <?php if (Session::userIsLoggedIn()) { ?>
                                <li <?php if (View::checkForActiveController($filename, "dashboard")) { echo ' class="active" '; } ?> >
                                    <a href="<?php echo Config::get('URL'); ?>dashboard/index">Dashboard</a>
                                </li>
                                <li <?php if (View::checkForActiveController($filename, "note")) { echo ' class="active" '; } ?> >
                                    <a href="<?php echo Config::get('URL'); ?>note/index">My Notes</a>
                                </li>
                                <?php } else { ?>
                                <!-- for not logged in users -->
                                <li <?php if (View::checkForActiveControllerAndAction($filename, "login/index")) { echo ' class="active" '; } ?> >
                                    <a href="<?php echo Config::get('URL'); ?>login/index">Login</a>
                                </li>
                                <li <?php if (View::checkForActiveControllerAndAction($filename, "register/index")) { echo ' class="active" '; } ?> >
                                    <a href="<?php echo Config::get('URL'); ?>register/index">Register</a>
                                </li>
                                <?php } ?>
                            </ul>

                            <!-- my account -->
                            <ul class="nav navbar-nav navbar-right">
                                <?php if (Session::userIsLoggedIn()) : ?>
                                    <li <?php if (view::checkforactivecontroller($filename, "user")) { echo ' class="active" '; } ?> >
                                        <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="<?php echo Config::get('URL'); ?>user/index">My Account</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo Config::get('URL'); ?>user/changeUserRole">Change account type</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo Config::get('URL'); ?>user/editAvatar">Edit your avatar</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo Config::get('URL'); ?>user/editusername">Edit my username</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo Config::get('URL'); ?>user/edituseremail">Edit my email</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo Config::get('URL'); ?>user/changePassword">Change Password</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo Config::get('URL'); ?>login/logout">Logout</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php if (Session::get("user_account_type") == 7) : ?>
                                        <li <?php if (View::checkForActiveController($filename, "admin")) {
                                            echo ' class="active" ';
                                        } ?> >
                                        <a href="<?php echo Config::get('URL'); ?>admin/">Admin</a>
                                    </li>
                                    <li <?php if (View::checkForActiveController($filename, "madmin")) {
                                        echo ' class="active" ';
                                    } ?> >
                                    <a href="<?php echo Config::get('URL'); ?>madmin/">mAdmin</a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div> <!-- /.container-fluid -->
        </nav>
    </div>
</div>