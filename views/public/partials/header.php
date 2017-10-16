<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
        <title>Simple TODO list</title>

        <link rel="shortcut icon" href="<?php echo URL; ?>images/favicon.png">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="<?php echo URL; ?>public/assets/vendor/material-design-lite/material.min.css">
        <link rel="stylesheet" href="<?php echo URL; ?>public/assets/css/styles.min.css"/>

    </head>

    <body>

        <?php
        $user_logged_in = isset( $_SESSION['user_id'] ) && !empty($_SESSION['user_id']);
        ?>
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header <?php echo $user_logged_in ? 'mdl-layout--fixed-drawer' : 'todo-layout--not-logged-in'; ?>">
            <header class="mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
                <div class="mdl-layout__header-row">

                    <h4 class="mdl-layout-title">Simple TODO list <span> - use "The Force" to create powerful notes!</span></h4>
                    <div class="mdl-layout-spacer"></div>

                    <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
                        <i class="material-icons">more_vert</i>
                    </button>
                    <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
                        <?php if ($user_logged_in) : ?>
                        <li class="mdl-menu__item">
                            <a class="mdl-navigation__link" href="<?php echo URL; ?>users/logout">Logout</a>
                        </li>
                        <?php else : ?>
                        <li class="mdl-menu__item">
                            <a class="mdl-navigation__link" href="<?php echo URL; ?>users/login">Login</a>
                        </li>
                        <?php endif; ?>
                        <li class="mdl-menu__item">
                            <a class="mdl-navigation__link" href="https://github.com/AleksandarPredic/todolist" target="_blank">GitHub</a>
                        </li>
                    </ul>
                </div>
            </header>

            <?php if ($user_logged_in) {  ?>
            <div class="drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">

                <header class="drawer-header">

                    <div class="avatar-dropdown">

                        <span><?php echo $_SESSION['email']; ?></span>

                    </div>
                </header>

                <nav class="navigation mdl-navigation mdl-color--blue-grey-800">
                    <a class="mdl-navigation__link" href="<?php echo URL; ?>"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Home</a>
                    <a class="mdl-navigation__link" href="<?php echo URL; ?>/home/create"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">add</i>Create</a>
                </nav>

            </div>
            <?php } ?>

            <main class="mdl-layout__content mdl-color--grey-100">
                <div class="mdl-grid content">



