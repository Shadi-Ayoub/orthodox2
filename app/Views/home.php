<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Greek Orthodox archbishopric - Control Panel</title>
        <link rel="stylesheet" href="assets/css/landing.css">
        <link rel="stylesheet" href="assets/plugins/bootstrap-4.0.0-dist/css/bootstrap.min.css">
    </head>
    <body>
        <div id="corner-login-button">
            <?php
                //if (auth()->loggedIn()) {
            ?>
                    <!-- <button type="button" onclick="location.href='<?= site_url('admin') ?>';" class="btn btn-block btn-info">Dashboard</button> -->
            <?php
                //}
                //else {
            ?>
                    <button type="button" onclick="location.href='<?= base_url('login','https') ?>';" class="btn btn-info">Login</button>
            <?php
                //}
            ?>
        </div>
        <div id="landing" >
            <div id="title-archbishopric-en"></div>
            <div id="logo-archbishopric-uae"></div>
            <div id="title-archbishopric-ar"></div>
        </div>
        <div id="msg-box">
            UNOFFICIAL WEBSITE - FOR INTERNAL USE ONLY!
        </div>
    </body>
</html>