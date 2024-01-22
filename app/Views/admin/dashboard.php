<?= $this->extend('admin/layout') ?>

<?= $this->section('pageTitle') ?>
    Dashboard
<?= $this->endSection() ?>

<?= $this->section('pageMeta') ?>
<?= $this->endSection() ?>

<?= $this->section('pageStyles') ?>
<?= $this->endSection() ?>

<?= $this->section('pageContent') ?>
    <?= "Dashboard"; ?>
    <?php
        // $arr = ["code1", "code2", "code3"];
        // echo json_encode($arr);
    ?>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<?= $this->endSection() ?>
