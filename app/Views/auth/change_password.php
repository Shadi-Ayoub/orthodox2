<?= $this->extend('auth/layout') ?>

<?php
    $component = service('component');
?>

<?= $this->section('pageTitle') ?>
    Change Password
<?= $this->endSection() ?>

<?= $this->section('pageMeta') ?>
<?= $this->endSection() ?>

<?= $this->section('pageStyles') ?>
<?= $this->endSection() ?>



<?= $this->section('pageContent') ?>
    <div class="login-form">
        <form id="form-change-password" action="/change-password" method="post">
            <h2 class="text-center">Change Password</h2>
            <?php
                if(isset($message) && trim($message) !== "") {
                    $component->alert($message_type, $message);
                }
            ?>

            <?php
                $component->password("old-password","Old Password");
                $component->password("new-password","New Password");
                $component->password("confirm-new-password","Confirm New Password");

                $note = "<b>Password requirements</b>" . "<br />" .
                        "Contains at least 1 number" . "<br />" .
                        "Contains at least 1 special character" . "<br />" .
                        "Contains at least 1 uppercase letter" . "<br />" .
                        "Contains at least 1 lowercase letter";

                $component->alert("info",$note, false, false);
            ?>

            <div class="d-grid mb-3">
                <button type="submit" id="btn-change-password" class="btn btn-primary login-btn btn-block">Change Password</button>
            </div>
        </form>
    </div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    
    <script>
        function isMatching() {
            var password = $("#new-password").val();
            var confirmPassword = $("#confirm-new-password").val();

            if (password != confirmPassword)
                return false;
            else
                return true;
        }

        $(document).ready(function(){
            $('#form-change-password').submit(function() {
                $('#overlay').fadeIn();
            });
            
            $( "#btn-change-password11" ).click(function() {
                chk = isMatching();

                var errorModal = new bootstrap.Modal(document.getElementById('modal-error'), {keyboard: false});

                if(chk) {
                    $( "#btn-change-password" ).submit();
                }
                else {
                    //var errorModal = new bootstrap.Modal(document.getElementById('modal-error'), {keyboard: false})
                    errorModal.show();
                }
            })
        });

    </script>
<?= $this->endSection() ?>
