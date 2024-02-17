<?php
    $lang = service('request')->getLocale();
    $current_path = uri_string();
?>

<?php
    $component = service('component');
?>

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
    <link rel="stylesheet" href=<?= base_url("assets/plugins/flag-icon-css/css/flag-icon.min.css"); ?>>
    <link rel="stylesheet" href=<?= base_url("assets/css/admin.css?v=" . filemtime(FCPATH . 'assets/css/admin.css')); ?>>
    <link rel="stylesheet" href=<?= base_url("assets/css/dropdown-main-menu.css?v=" . filemtime(FCPATH . 'assets/css/dropdown-main-menu.css')); ?>>
    <link rel="stylesheet" href=<?= base_url("assets/css/overlay-spinner.css"); ?>>

    <?= $this->renderSection('pageStyles') ?>
<?= $this->endSection() ?>


<?= $this->section('pageContent') ?>
    <?php $component->spinner(); ?>
    
    <main role="main" class="admin-container">
        <?php $component->spinner(); ?>
        <?php $component->modal('about-technical'); ?>

        <?php
            require("header.php");
            $this->renderSection('breadcrumbsBar');
        ?>

        <div id="content" >
            <?= $this->renderSection('pageContent') ?>
        </div>

        <?php
            require("footer.php");
        ?>
    </main>

    <?php
        require("footer.php");
    ?>

    <?php $component->modal("error",""); ?>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src=<?= base_url("assets/plugins/bootstrap-5.1.3-dist/js/bootstrap.min.js"); ?>></script>

    <script>
        $( document ).ready(function() {
            $('#logoutLink a').click(function() {
                $('#overlay').fadeIn();
                location.href='<?= site_url('logout') ?>';
            });

            $('a.dropdown-item').click(function(event) {
                event.preventDefault(); // Prevent the default anchor click behavior

                if ($(this).hasClass('active')) { // no need to call the same current page!
                    return;
                }

                $('#overlay').fadeIn();

                // Read the data value of the clicked anchor
                const dataValue = $(this).data('urlstring');

                location.href='<?= base_url() ?>' + dataValue;
            });
        });
    </script>

    <?= $this->renderSection('pageScripts') ?>
<?= $this->endSection() ?>