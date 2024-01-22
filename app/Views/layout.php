<!DOCTYPE html>
<html lang="en">

    <head>
        <?= $this->renderSection('pageTitle') ?>

        <?= $this->renderSection('pageMeta') ?>

        <link rel="stylesheet" href=<?= base_url("assets/css/main.css?v=" . filemtime(FCPATH . 'assets/css/auth.css')); ?>>
        <?= $this->renderSection('pageStyles') ?>
    </head>

    <body>
        <?= $this->renderSection('pageContent') ?>
        <?= $this->renderSection('pageScripts') ?>
    </body>

</html>