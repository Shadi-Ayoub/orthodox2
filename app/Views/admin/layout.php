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
    <link rel="stylesheet" href=<?= base_url("assets/plugins/flag-icon-css/css/flag-icon.min.css"); ?>>
    <link rel="stylesheet" href=<?= base_url("assets/css/dashboard.css?v=" . filemtime(FCPATH . 'assets/css/dashboard.css')); ?>>
    <link rel="stylesheet" href=<?= base_url("assets/css/overlay-spinner.css"); ?>>

    <?php
        if($lang == 'ar') {
    ?>
            <link rel="stylesheet" href=<?= base_url("assets/css/dashboard-rtl.css?v=" . filemtime(FCPATH . 'assets/css/dashboard-rtl.css')); ?>>
    <?php
        }
    ?>

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

    <?php $component->modal("error",""); ?>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src=<?= base_url("assets/plugins/bootstrap-5.1.3-dist/js/bootstrap.min.js"); ?>></script>
    <script src=<?= base_url("assets/plugins/sweetalert2/js/sweetalert2.all.min.js"); ?>></script>

    <script>
        $( document ).ready(function() {
            // https://sweetalert2.github.io/
            // https://github.com/sweetalert2/sweetalert2/releases
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            $('#logoutLink a').click(function() {
                $('#overlay').fadeIn();
                location.href='<?= site_url('logout') ?>';
            });

            $("#lang-menu-dropdown .dropdown-item").click(function() {
                if ($(this).hasClass('active')) { // no need to call the same current page!
                    return;
                }

                $('#input-lang').val($(this).data('lang'));
                $('#form-change-language').submit();
                $('#overlay').fadeIn();
            });

            $('#main-menu-dropdown a.dropdown-item').click(function(event) {
                event.preventDefault(); // Prevent the default anchor click behavior

                if ($(this).hasClass('active')) { // no need to call the same current page!
                    return;
                }

                if ($(this).hasClass('dropdown-toggle')) {
                    return;
                }

                $('#overlay').fadeIn();

                // Read the data value of the clicked anchor
                const dataValue = $(this).data('urlstring');

                location.href='<?= base_url() ?>' + dataValue;
            });

            $('#congregations-menu-dropdown a.dropdown-item').click(function(event) {
                event.preventDefault(); // Prevent the default anchor click behavior

                if ($(this).hasClass('active')) { // no need to call the same current page!
                    return;
                }

                alert($(this).data('congregation-id'));
                return;

                // $('#input-lang').val($(this).data('lang'));
                // $('#form-change-language').submit();
                // $('#overlay').fadeIn();
            });

            <?= $component->idel_timeout_javascript(service("session")->get("system_settings")["session"]["idle_timeout"], site_url('logout')); ?>
        });
    </script>

    <?= $this->renderSection('pageScripts') ?>
<?= $this->endSection() ?>