<?php
    $lang = service('request')->getLocale();
?>

<!DOCTYPE html>
<html lang=<?= $lang ?>>

    <head>
        <?= $this->renderSection('pageTitle') ?>

        <?= $this->renderSection('pageMeta') ?>

        <?php
            if($lang == 'ar') {
        ?>
            <link rel="stylesheet" href=<?= base_url('assets/plugins/bootstrap-5.1.3-dist/css/bootstrap.rtl.min.css'); ?>>
        <?php
            }
            else {
        ?>
            <link rel="stylesheet" href=<?= base_url('assets/plugins/bootstrap-5.1.3-dist/css/bootstrap.min.css'); ?>>
        <?php
            }
        ?>

        <link rel="stylesheet" href=<?= base_url("assets/plugins/fontawesome-free-6.4.2-web/css/all.min.css"); ?>>
        <link rel="stylesheet" href=<?= base_url("assets/css/main.css?v=" . filemtime(FCPATH . 'assets/css/auth.css')); ?>>
        <?= $this->renderSection('pageStyles') ?>
    </head>

    <body>
        <?= $this->renderSection('pageContent') ?>
        <?= $this->renderSection('pageScripts') ?>
    </body>

</html>