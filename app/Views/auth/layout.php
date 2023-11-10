<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title><?= $this->renderSection('title') ?></title>
        
        <link rel="stylesheet" href="assets/plugins/bootstrap-5.1.3-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/plugins/fontawesome-free-6.4.2-web/css/all.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="assets/plugins/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>

        <?= $this->renderSection('pageStyles') ?>

        <style>
            .login-form-logo {
                margin: auto;
                margin-top: 5%;
                width: fit-content;
                /* height: 150px; */
            }

            .logo-img {
                max-width: 100%;
                height: 200px;
                display: block; /* remove extra space below image */
                margin: auto;
            }

            .login-form {
                width: 440px;
                margin: 10px auto;
                font-size: 15px;
            }
            .login-form form {
                margin-bottom: 15px;
                background: #f7f7f7;
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                padding: 30px;
            }
            .login-form h2 {
                margin: 0 0 15px;
            }
            .form-control, .btn {
                font-size: 15px;
                font-weight: bold;
                /* min-height: 38px;
                border-radius: 2px; */
            }
            .btn {        
                font-size: 15px;
                font-weight: bold;
            }
            .alert svg {
                display: inline-block;
                /* width: 24px; */
                height: 24px;
                /* margin: auto; */
            }
        </style>
    </head>
    <body>
        <main role="main" class="container">
            <div class="position-absolute top-50 start-50 translate-middle">
                <div class="text-center">
                    <a href="<?= base_url('') ?>">
                        <img src='assets/img/logo-archbishopric-uae-2_73cm-3_44cm-600dpi.jpg' alt="Greek Orthodox archbishopric Logo" class="logo-img" />
                    </a>
                </div>
                <?= $this->renderSection('main') ?>
            </div>
        </main>

        <?= $this->renderSection('pageScripts') ?>
    </body>
</html>