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
        <link rel="stylesheet" href="assets/plugins/bootstrap-5.1.3-dist/css/bootstrap.min.css">
    </head>
    <body>
        <div id="corner-login-button">
            <?php
                $dashboard_url_string = ($access_type === ACCESS_TYPE_ADMIN ? "admin/dashboard" : "dashboard");
                $logout_url_string = ($access_type === ACCESS_TYPE_ADMIN ? "admin/logout" : "logout");
                
                if ($logged_in) {
            ?>
                    <button type="button" onclick="location.href='<?= base_url($dashboard_url_string,'https') ?>';" class="btn btn-block btn-info">Dashboard</button>
                    <button type="button" onclick="location.href='<?= base_url($logout_url_string,'https') ?>';" class="btn btn-block btn-warning">Logout</button>
            <?php
                }
                else {
            ?>
                    <button type="button" onclick="location.href='<?= base_url('admin/login','https') ?>';" class="btn btn-info">Login</button>
            <?php
                }
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