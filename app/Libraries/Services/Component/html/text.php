<?php
    $class_dir = ($dir == 'rtl') ? ' form-control-arabic' : '';

    $class_mode ='';

    switch ($mode) {
        case 'alpha-arabic-only':
            $class_mode = ' arabic-text-only';
            break;
        case 'alphanumeric-arabic-only':
            $class_mode = ' arabic-text-numeric-only';
            break;
        case 'alpha-english-only':
            $class_mode = ' english-text-only';
            break;
        default:
            $class_mode = '';
    }

    $required = $required ? 'required' : '';

    $disabled = $disabled ? 'disabled' : '';

    $class = $class === "" ? '' : ' ' . $class;
?>

<?php

    switch($as) {
        case "username":
?>
            <div class="input-group mb-3">
                <span class="input-group-text">
                    <i class="fa fa-user"></i>
                </span>        
                <input type="text" value="<?= $value; ?>" id="<?= $control_name; ?>" name="<?= $control_name; ?>" class="form-control<?=$class; ?>" autocomplete="off" placeholder="<?= $placeholder; ?>" autocomplete="on" required="required" maxlength="<?= $max_length; ?>" size="<?= $size; ?>" <?= $js; ?>>				
            </div>
<?php
            break;
        case "secret":
?>
            <div id="show-secret" class="input-group mb-3 <?=$class; ?>">
                <span class="input-group-text clickable">
                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                </span>
                <input type="password" value="<?= $value; ?>" id="<?= $control_name; ?>" name="<?= $control_name; ?>" class="form-control" autocomplete="off" placeholder="<?= $placeholder; ?>" autocomplete="on" required="required" maxlength="<?= $max_length; ?>" size="<?= $size; ?>" <?= $js; ?>>
                <!-- <button class="btn btn-outline-secondary" type="button" id="password-toggle" onclick="toggleSecret()"><i class="fa fa-user"></i></button> -->
            </div>
<?php
            break;
        default:
?>
            <input type="text" value="<?= $value; ?>" id="<?= $control_name; ?>" name="<?= $control_name; ?>" class="form-control<?= $class_dir . $class_mode; ?><?=$class; ?>" autocomplete="off" placeholder="<?= $placeholder; ?>" <?= $required; ?> <?= $disabled; ?> maxlength="<?= $max_length; ?>" size="<?= $size; ?>" <?= $js; ?>>
<?php
    }
?>

