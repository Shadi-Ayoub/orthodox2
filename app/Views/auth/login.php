<?php
    use App\Controllers\AuthController;
?>

<?= $this->extend('auth/layout') ?>

<?php
    $component = service('component');
?>

<?= $this->section('pageTitle') ?>
    Login
<?= $this->endSection() ?>

<?= $this->section('pageMeta') ?>
<?= $this->endSection() ?>

<?= $this->section('pageStyles') ?>
<?= $this->endSection() ?>

<?= $this->section('pageContent') ?>
    <div class="login-form">
        <form id="form-login" action="<?= $access_type == ACCESS_TYPE_ADMIN ? site_url("admin/login") : site_url("login"); ?>" method="post">
            <h2 class="text-center"><?= $access_type == ACCESS_TYPE_ADMIN ? "Admin " : ""; ?>Sign in</h2>

            <?php
                if(isset($message) && trim($message) !== "") {
                    $component->alert($message_type,$message);
                }
            ?>

            <?php $component->text("username", as: "username", placeholder: "Username"); ?>
            <?php $component->password("password", "Password"); ?>
            <?php $component->recaptcha(); ?>
            
            <?= csrf_field(); ?>
            
            <div class="d-grid mb-3">
                <button id="btn-submit" type="submit" class="btn btn-primary btn-block">Sign in</button>
            </div>
            
            <div class="clearfix">
                <label class="float-start form-check-label"><input name="remember-me" type="checkbox"> Remember me</label>
                <a href="#" class="float-end">Forgot Password?</a>
            </div>
        </form>
        <p class="text-center"><a href="#">Create an Account</a></p>
    </div>

    <?php // $component->recaptcha_statement(); ?>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

    <?php $component->recaptcha_javascript(); ?>

    <script>
        $(document).ready(function(){
            $('#username').focus();

            $('#form-login').submit(function() {
                $('#overlay').fadeIn();
            });
        });
    </script>
<?= $this->endSection() ?>