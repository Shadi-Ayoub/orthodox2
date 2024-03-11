<?php
    $properties = "";

    Foreach($props as $key => $value) {
        $properties = $properties . " " . $key . "=" . "\"" . $value . "\"";
    }

    if($label !== "") {
?>
    <label for="<?= $control_name; ?>" class="form-label mt-2 ms-2"><?= $label; ?></label>
<?php
    }
?>
<div class="input-group ms-2<?= ($label === "" ? ' mt-2' : ''); ?>">
    <span class="input-group-text">
        <i class="fa fa-hashtag"></i>
    </span>
    <input type="number" class="form-control" name="<?= $control_name; ?>" id="<?= $control_name; ?>" value="<?= $value; ?>" <?= $required ? " required" : ""; ?> <?= trim($properties); ?>>				
</div>