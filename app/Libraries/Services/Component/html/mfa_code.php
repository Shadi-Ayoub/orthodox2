<div class="input-group mb-3">
    <span class="input-group-text">
        <i class="fa-solid fa-key"></i>
    </span>        
    <input type="text" value="<?= $value; ?>" id="<?= $control_name; ?>" name="<?= $control_name; ?>" class="form-control<?=$class; ?>" autocomplete="off" autocomplete="off" required maxlength="6" size="8" oninput="this.value=this.value.replace(/[^0-9]/g,'')">				
</div>