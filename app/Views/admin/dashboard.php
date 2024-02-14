<?= $this->extend('admin/layout') ?>

<?= $this->section('pageTitle') ?>
    Dashboard
<?= $this->endSection() ?>

<?= $this->section('pageMeta') ?>
<?= $this->endSection() ?>

<?= $this->section('pageStyles') ?>
<?= $this->endSection() ?>

<?= $this->section('breadcrumbsBar') ?>
    <?= $breadcrumbs; ?>
<?= $this->endSection() ?>

<?= $this->section('pageContent') ?>
    <?= "Dashboard"; ?>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<?= $this->endSection() ?>
