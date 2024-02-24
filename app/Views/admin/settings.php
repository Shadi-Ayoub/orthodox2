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

<?= $this->section('breadcrumbsBar') ?>
    <?= $breadcrumbs; ?>
<?= $this->endSection() ?>

<?= $this->section('pageContent') ?>
    <?php
        if(isset($message) && trim($message) !== "") {
            $component->alert($message_type,$message);
        }
    ?>

    <div id="admin-settings-container" class="container border p-3 w-75">
        <ul class="nav nav-pills mb-3 justify-content-center border" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= $active_tab =="general" ? "active" : ""; ?>" id="pills-home-tab" data-value="general" data-bs-toggle="pill" data-bs-target="#pills-general" type="button" role="tab" aria-controls="pills-general" aria-selected="true">General</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= $active_tab =="login" ? "active" : ""; ?>" id="pills-profile-tab" data-value="login" data-bs-toggle="pill" data-bs-target="#pills-login" type="button" role="tab" aria-controls="pills-login" aria-selected="false">Login</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= $active_tab =="other" ? "active" : ""; ?>" id="pills-other-tab" data-value="other" data-bs-toggle="pill" data-bs-target="#pills-other" type="button" role="tab" aria-controls="pills-other" aria-selected="false">Other</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= $active_tab =="json" ? "active" : ""; ?>" id="pills-json-tab" data-value="json" data-bs-toggle="pill" data-bs-target="#pills-json" type="button" role="tab" aria-controls="pills-json" aria-selected="false">JSON</button>
            </li>
        </ul>
        <div class="tab-content d-flex align-items-center justify-content-center border" id="settings-pills-tabContent">
            <div class="tab-pane fade <?= $active_tab =="general" ? "show active" : ""; ?> border w-100" style="height: 300px" id="pills-general" role="tabpanel" aria-labelledby="pills-general-tab">General Settings...</div>
            <div class="tab-pane fade <?= $active_tab =="login" ? "show active" : ""; ?> border p-5 w-100" style="height: 300px" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="loginForcePasswordChangeSwitch" data-settings-key1="login" data-settings-key2="force_password_change" <?= $settings_array["login"]["force_password_change"] === "yes" ? "checked" : "";  ?>>
                    <label class="form-check-label" for="loginForcePasswordChangeSwitch">Force password change for new users on their first login.</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="loginForceMfaAdminSwitch" data-settings-key1="login" data-settings-key2="force_mfa_admin" <?= $settings_array["login"]["force_mfa_admin"] === "yes" ? "checked" : "";  ?>>
                    <label class="form-check-label" for="loginForceMfaAdminSwitch">Force Multi-factor Authentication to all Administrators.</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="loginForceMfaUserSwitch" data-settings-key1="login" data-settings-key2="force_mfa_user" <?= $settings_array["login"]["force_mfa_user"] === "yes" ? "checked" : "";  ?>>
                    <label class="form-check-label" for="loginForceMfaUserSwitch">Force Multi-factor Authentication to all users.</label>
                </div>
            </div>
            <div class="tab-pane fade <?= $active_tab =="other" ? "show active" : ""; ?> border w-100" style="height: 300px" id="pills-other" role="tabpanel" aria-labelledby="pills-other-tab">Other Settings...</div>
            <div class="tab-pane fade <?= $active_tab =="json" ? "show active" : ""; ?> border w-100" style="height: 300px" id="pills-json" role="tabpanel" aria-labelledby="pills-json-tab">
                <div class="container">
                    <!-- Row for headers -->
                    <div class="row mb-2 mt-2"> <!-- mb-2 for some spacing between headers and content rows -->
                        <div class="col-sm">
                            <!-- Header 1 -->
                            <div class="bg-info text-gray text-center p-2 rounded">Current Settings</div>
                        </div>
                        <div class="col-sm">
                            <!-- Header 2 -->
                            <div class="bg-success text-white text-center p-2 rounded">New Settings</div>
                        </div>
                        <div class="col-sm">
                            <!-- Header 3 -->
                            <div class="bg-secondary text-white text-center p-2 rounded">Default Settings</div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="current-settings-array" class="col-sm">
                            Current Settings as an Array
                        </div>
                        <div id="new-settings-array" class="col-sm">
                            New Settings as an Array to be saved upon clicking the "Save" button
                        </div>
                        <div id="default-settings-array" class="col-sm">
                            Default Settings as an Array to be saved upon clicking the "Reset" button
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Buttons row -->
        <div class="row justify-content-between mt-3">
            <!-- Reset button on the left -->
            <div class="col-auto">
                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-confirm-reset-settings">
                    Reset
                </button>
            </div>
            
            <!-- Placeholder column to push the other buttons to the right -->
            <div class="col">
            </div>
            
            <!-- Back and Save buttons on the right -->
            <div class="col-auto">
                <button id="btn-back" type="button" class="btn btn-sm btn-secondary">
                    Back
                </button>
                <button id="btn-save-settings" type="button" class="btn btn-sm btn-success">
                    Save
                </button>
            </div>
        </div>
    </div>
    <input type="hidden" id="hidden-settings-change-status" value="0" />
    <form id="form-reset-settings" action="<?=  site_url("admin/settings/reset"); ?>" method="post">
        <input type="hidden" name="reset-settings-confirmed" value="">
        <?= csrf_field(); ?>
    </form>
    <form id="form-save-settings" action="<?=  site_url("admin/settings/save"); ?>" method="post">
        <input type="hidden" name="save-settings-json-string" id="save-settings-json-string" value="">
        <?= csrf_field(); ?>
    </form>

    <?php
        //  echo "<pre>";
        //  print_r($settings_array);
        //  echo "</pre>";
    ?>

    <!-- Modal -->
    <div class="modal fade" id="modal-confirm-reset-settings" tabindex="-1" aria-labelledby="modalConfirmResetSettings" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirmResetSettingsLabel">Reset Settings</h5>
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
            $("#btn-save-settings").prop('disabled', true);

            const currentSettingsObj = <?= json_encode($settings_array); ?>;
            const newSettingsObj = <?= json_encode($settings_array); ?>;
            const defaultSettingsObj = <?= json_encode($default_settings_array); ?>;

            displaySettingsObject(currentSettingsObj, 'current-settings-array');
            displaySettingsObject(newSettingsObj, 'new-settings-array');
            displaySettingsObject(defaultSettingsObj, 'default-settings-array');

            $('#btn-confirm-reset-settings').click(function() {
                $('#form-reset-settings').submit();
                $('#modal-confirm-reset-settings').modal('hide');
                $('#overlay').fadeIn();
            });

            $('#btn-save-settings').click(function() {
                this.blur();
                newSettingsJsonString = JSON.stringify(newSettingsObj);
                $('#save-settings-json-string').val(newSettingsJsonString);
                // alert($('#save-settings-json-string').val());
                // return;
                $('#form-save-settings').submit();
                $('#overlay').fadeIn();
            });

            $('#btn-back').click(function() {
                $('#overlay').fadeIn();
                window.location.href = '<?=   session()->get("backToUrl"); ?>';
            });

            // Set up a MutationObserver to listen for changes to the hidden status input value
            var observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === "attributes" && mutation.attributeName === "value") {
                        updateSaveButtonState();
                    }
                });
            });

            // Observe changes to the hidden input to track current settings change
            var hiddenSaveStatusInput = document.getElementById('hidden-settings-change-status'); // jQuery object to DOM for observer
            observer.observe(hiddenSaveStatusInput, { attributes: true, attributeFilter: ['value'] });

            function isSettingsChanged() {
                var isChanged = !(deepEqual(JSON.stringify(currentSettingsObj), JSON.stringify(newSettingsObj)));

                if(isChanged) {
                    return "1";
                }

                return "0";
            }

            function displaySettingsObject(obj, outputId) {
                var $output = $('#' + outputId);
                $output.empty(); // Clear previous content
                printStr = '';
                $.each(obj, function(key, objSettings) {
                    printStr = `${key}:` + "\n";
                    $.each(objSettings, function(key, value) {
                        printStr = printStr + '   ' + `${key}: ${value}`  + "\n";
                    });
                    $('<pre>').text(printStr).appendTo($output);
                });
            }

            // Function to check the hidden input value and update the button state
            function updateSaveButtonState() {
                const saveStatus = $('#hidden-settings-change-status').val(); // Using jQuery for value
                const $button = $('#btn-save-settings'); // Using jQuery to select the button
                
                // if(saveStatus !== "1") {
                //     $("#btn-save-settings").prop('disabled', true);
                // } else {
                //     $("#btn-save-settings").prop('disabled', false);
                // }

                // Enable the button if hiddenInputValue is "1"
                $button.prop('disabled', saveStatus !== "1");
            }

            // Function to handle switch change event
            $('.form-check-input').on('change', function() {
                // Reading the switch value and data attributes
                var isChecked = $(this).prop('checked');
                var settingsKey1 = $(this).data('settings-key1');
                var settingsKey2 = $(this).data('settings-key2');

                // alert("isChecked: " + isChecked + "<br />" + "settingsKey1: " + settingsKey1 + "settingsKey2: " + settingsKey2)

                if(isChecked) {
                    newSettingsObj[settingsKey1][settingsKey2] = "yes";
                } else {
                    newSettingsObj[settingsKey1][settingsKey2] = "no";
                }

                displaySettingsObject(currentSettingsObj, 'current-settings-array');
                displaySettingsObject(newSettingsObj, 'new-settings-array');

                flag = isSettingsChanged();

                $('#hidden-settings-change-status').attr('value', flag);

                // alert($('#hidden-settings-change-status').attr('value'));

                // alert($('#hidden-settings-change-status').val());
                // // Logging the switch info
                // console.log("Checked:", isChecked);
                // console.log("Settings Key 1:", settingsKey1);
                // console.log("Settings Key 2:", settingsKey2);
            });

            // Function to handle tabs click event
            $('.nav-link').on('click', function() {
                let cookieJsonObj = JSON.parse(getCookie('<?= $cookie_ux_name; ?>'));
                
                cookieJsonObj.settings.active_tab = $(this).data('value');
                // alert($(this).data('value'));
                // return;
                cookieJsonString = JSON.stringify(cookieJsonObj);
                // alert(JSON.stringify(cookieJsonObj));
                // alert(cookieJsonString);
                document.cookie = "<?= $cookie_ux_name; ?>=" + cookieJsonString;
            });

            // Function to read a cookie's value
            function getCookie(name) {
                let cookieArray = document.cookie.split('; ');
                for(let i = 0; i < cookieArray.length; i++) {
                    let cookiePair = cookieArray[i].split('=');
                    if (name === cookiePair[0]) {
                        return decodeURIComponent(cookiePair[1]);
                    }
                }
                return null;
            }

            function deepEqual(obj1, obj2) {
                if (obj1 === obj2) {
                    return true;
                }

                if (obj1 == null || typeof obj1 != "object" || obj2 == null || typeof obj2 != "object") {
                    return false;
                }

                let keysObj1 = Object.keys(obj1), keysObj2 = Object.keys(obj2);

                if (keysObj1.length != keysObj2.length) {
                    return false;
                }

                for (let key of keysObj1) {
                    if (!keysObj2.includes(key) || !deepEqual(obj1[key], obj2[key])) {
                        return false;
                    }
                }

                return true;
            }
        });
    </script>
<?= $this->endSection() ?>
