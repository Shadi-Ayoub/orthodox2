<!DOCTYPE html>
<html lang="en">


    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>GraphQL Query Error Page</title>
        <link rel="stylesheet" href=<?= base_url("assets/plugins/bootstrap-5.1.3-dist/css/bootstrap.min.css"); ?>>
    </head>


    <body>
        <div class="d-flex align-items-center justify-content-center vh-100">
            <div class="text-center">
                <h1 class="display-1 fw-bold">GraphQL Query Error!</h1>
                <p class="fs-3"> <span class="text-danger">Opps!</span> Invalid Query...</p>
                <p class="lead">
                    The previous page has sent an invalid query to the API!
                </p>
                    <?php
                        if ($_SERVER['CI_ENVIRONMENT'] == "development" && session()->getFlashdata('fail-message')) {
                    ?>
                            <div class="alert alert-danger text-start" role="alert">
                    <?php
                            echo $message;
                    ?>
                        </div>
                    <?php        
                        }
                    ?>
                  
                <a href="<?=  site_url("/"); ?>" class="btn btn-primary">Go Home</a>
            </div>
        </div>
    </body>


</html>