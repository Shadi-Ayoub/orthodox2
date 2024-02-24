<?= $this->extend('auth/layout') ?>

<?php
    $component = service('component');
    $session = service("session");
    $login_url_string = "/login";

    if($session->get('accessType') === ACCESS_TYPE_ADMIN) {
        $login_url_string = "admin/login";
    }
?>

<?= $this->section('pageTitle') ?>
    MFA Setup
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

    <h1 class="text-center mb-4">Configuring Multi-Factor Authentication</h1>

    <div class="mfa-setup-form">
        <form id="form-maf-setup" action="/mfa-setup" method="post">
            <p style="text-align: justify;" class="mb-4">
                <span class="text-success">
                    Multi-factor authentication (MFA) is based on the Time-based One-Time Password (TOTP) method that requires users to verify their identity by providing a temporary six-digit code sent by an authentication application to a trusted device. As your account is configured to force using MFA, you need to do the required setup by following the steps below.
                </span>
            </p>
            <ol>
                <li class="fw-bold mb-3">
                    Install a recommended authentication application on your mobile or computer (we recommend <a href="https://www.microsoft.com/en/security/mobile-authenticator-app" target="_blank">Microsoft Authenticator</a>).
                </li>

                <li class="fw-bold mb-3">
                    In the authenticator app, tab on the + icon at the top to Add the account.
                </li>

                <li class="fw-bold mb-3">
                    Choose the account type (choose "Other").
                </li>

                <li class="fw-bold mb-3">
                    Scan the displayed QR code to associate the authentication application with the authorization server.
                    <?php
                        $qr = service('qr');
                        // format: otpauth://totp/{issuer}:{account-name}?secret={secret-key}&issuer={issuer}
                        $uri = sprintf(
                            'otpauth://totp/%s:%s?secret=%s&issuer=%s',
                            $_ENV['COGNITO_ISSUER_AUTHENTICATOR'],
                            $username,
                            $secret,
                            $_ENV['COGNITO_ADMIN_USER_POOL_ISSUER'],
                        );

                        // $qr_code = $qr->generate_qr_png(Base32::encode($secret));
                        $qr_code = $qr->generate_qr_png($uri);
                    ?>
                    <div id="qr-box" class="text-center">
                        <div id="qr-png">
                            <img class="w-25" src=<?= $qr_code; ?> />
                        </div>
                    </div>
                    
                    Alternatively, enter the following secret key manually (click the eye icon to show):
                    <?= $component->text("secret-code",value:$secret, as:"secret", disabled:true, class:"mt-2 text-black-50 fs-6"); ?>
                </li>

                <li class="fw-bold mb-6">
                    Enter the one-time verification code that currently appears in the app:
                    <?= $component->mfa_code("totp");?>
                </li>
            </ol>

            <?= csrf_field(); ?>
            
            <div class="text-center mb-5">
                <button type="button" id="btn-mfa-setup-cancel" class="btn btn-secondary cancel-btn btn-block">Cancel</button>
                <button type="button" id="btn-mfa-setup-submit" class="btn btn-primary login-btn btn-block">Apply</button>
            </div>
        </form>
    </div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    
    <script>
        $(document).ready(function(){
            function formSubmit() {
                alert();
                
                return;
            }

            $( "#btn-mfa-setup-submit" ).on( "click", function(e) {
                totp = $( "#totp" ).val();
                if(totp == "") {
                    alert();
                    return;
                }
                    
                $( "#secret-code" ).val("");
                $("#form-maf-setup").submit();
            });

            $( "#show-secret" ).on( "click", function(e) {
                e.preventDefault();
                var eye = $(this).parent().find('i');
                eye.toggleClass("fa-eye fa-eye-slash");
                // First get parent, then find the correct input within that parent.
                var input = $(this).parent().find('input');
                input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password');
                input.blur();
            });

            $("#btn-mfa-setup-cancel").on( "click", function(e) {
                location.href = '<?= site_url($login_url_string); ?>' //returns to login
            });
        });
    </script>
<?= $this->endSection() ?>
