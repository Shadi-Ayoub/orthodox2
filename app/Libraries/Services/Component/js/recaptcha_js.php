<?php
/**
 * define the environment variable "Google.reCaptchaV3.sitekey" in the .env file.
 * The hidden field in the form need to have the id value "g-recaptcha-response"
 */
?>
<!-- reCaptcha V3-->
<script src="https://www.google.com/recaptcha/api.js?render=<?= getenv('Google.reCaptchaV3.sitekey') ?>"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute("<?= getenv('Google.reCaptchaV3.sitekey') ?>", {action: 'submit'}).then(function(token) {
            $('#g-recaptcha-response').val(token);
        });
    });
</script>