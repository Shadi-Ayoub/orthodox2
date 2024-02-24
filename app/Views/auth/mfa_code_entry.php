<?php
    $component = service('component');
?>

<?= $this->extend('auth/layout') ?>

<?= $this->section('pageTitle') ?>
    MFA Code Entry
<?= $this->endSection() ?>

<?= $this->section('pageMeta') ?>
<?= $this->endSection() ?>

<?= $this->section('pageStyles') ?>
<?= $this->endSection() ?>

<?= $this->section('pageContent') ?>
    <div class="mfa-code-entry-form">
        
        <?php
            if(isset($message) && trim($message) !== "") {
                $component->alert($message_type, $message);
            }
        ?>
        <form id="form-mfa-code" action="/admin/mfa-code-entry" method="post">
            <h3 class="text-center">Multi-factor Authentication</h3>
            
            <p class="text-center">Open the authenticator application on your mobile device and enter the provided 6-digit code. </p>
            
            <?php
                $component->mfa_code("totp");
            ?>

            <?= csrf_field(); ?>

            <div class="d-grid mb-3">
                <button type="submit" id="btn-change-password" class="btn btn-primary login-btn btn-block">Verify</button>
            </div>
        </form>
    </div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $('#totp').focus();

            $('#form-mfa-code').submit(function() {
                $('#overlay').fadeIn();
            });
        });
    </script>

<?= $this->endSection() ?>
