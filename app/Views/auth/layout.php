<?= $this->extend('layout') ?>

<?php
    $component = service('component');
?>

<?= $this->section('pageTitle') ?>
    <title><?= $this->renderSection('pageTitle') ?></title>
<?= $this->endSection() ?>

<?= $this->section('pageMeta') ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?= $this->renderSection('pageMeta') ?>
<?= $this->endSection() ?>

<?= $this->section('pageStyles') ?>
    <link rel="stylesheet" href=<?= base_url("assets/plugins/bootstrap-5.1.3-dist/css/bootstrap.min.css"); ?>>
    <link rel="stylesheet" href=<?= base_url("assets/plugins/fontawesome-free-6.4.2-web/css/all.min.css"); ?>>
    <link rel="stylesheet" href=<?= base_url("assets/css/auth.css?v=" . filemtime(FCPATH . 'assets/css/auth.css')); ?>>
    <link rel="stylesheet" href=<?= base_url("assets/css/overlay-spinner.css"); ?>>

    <?= $this->renderSection('pageStyles') ?>
<?= $this->endSection() ?>


<?= $this->section('pageContent') ?>

    <?php $component->spinner(); ?>
    
    <main role="main" class="auth-container">
        <?php
            require("header.php");
        ?>

        <div id="content" >
            <div class="logo-canvas">
                <a href="<?= base_url('') ?>">
                    <img src=<?= base_url("assets/img/logo-archbishopric-uae-2_73cm-3_44cm-600dpi.jpg"); ?> alt="Greek Orthodox archbishopric Logo" class="logo-img" />
                </a>
            </div>
            <?= $this->renderSection('pageContent') ?>
        </div>

        <?php
            require("footer.php");
        ?>
    </main>

    <?php $component->modal("error",""); ?>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src=<?= base_url("assets/plugins/bootstrap-5.1.3-dist/js/bootstrap.min.js"); ?>></script>
    <?= $this->renderSection('pageScripts') ?>
<?= $this->endSection() ?>