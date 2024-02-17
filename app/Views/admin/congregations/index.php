<?= $this->extend('admin/layout') ?>

<?= $this->section('pageTitle') ?>
    Congregations Management
<?= $this->endSection() ?>

<?= $this->section('pageMeta') ?>
<?= $this->endSection() ?>

<?= $this->section('pageStyles') ?>
<?= $this->endSection() ?>

<?= $this->section('breadcrumbsBar') ?>
    <?= $breadcrumbs; ?>
<?= $this->endSection() ?>

<?= $this->section('pageContent') ?>
    <?= "Congregations List"; ?>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<?= $this->endSection() ?>
