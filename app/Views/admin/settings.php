<?= $this->extend('admin/layout') ?>

<?php
    $component = service('component');
?>

<?= $this->section('pageTitle') ?>
    Manage Settings
<?= $this->endSection() ?>

<?= $this->section('pageMeta') ?>
<?= $this->endSection() ?>

<?= $this->section('pageStyles') ?>
<?= $this->endSection() ?>

<?= $this->section('pageContent') ?>
    <?php
        if(isset($message) && trim($message) !== "") {
            $component->alert($message_type,$message);
        }
    ?>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-confirm-reset-settings">
        Reset Settings
    </button>

    <form id="form-reset-settings" action="<?=  site_url("settings/reset");  ?>" method="post">
        <input type="hidden" name="reset-settings-confirmed" value="">
    </form>

    <!-- Modal -->
    <div class="modal fade" id="modal-confirm-reset-settings" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reset Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to reset all settings to the default values?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="btn-confirm-reset-settings">Reset Settings</button>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
    <script>
        $(document).ready(function() {
            $('#btn-confirm-reset-settings').click(function() {
                $('#form-reset-settings').submit();
                $('#modal-confirm-reset-settings').modal('hide');
                $('#overlay').fadeIn();
            });
        });
    </script>
<?= $this->endSection() ?>
