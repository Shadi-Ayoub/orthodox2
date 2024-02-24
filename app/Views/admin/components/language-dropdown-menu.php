<!-- Language Dropdown Menu -->
<?php
    $lang = service('request')->getLocale();

    $idiom = 'gb';

    switch($lang) {
        case "en":
            $idiom = 'gb';
            break;
        case "ar":
            $idiom = 'ae';
            break;
        default:
            $idiom = 'gb';
    }
?>

<div id="lang-menu-dropdown" class="btn-group d-flex align-items-center">
    <div data-bs-toggle="dropdown">
        <i class="flag-icon flag-icon-<?= $idiom; ?>"></i>
    </div>

    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a class="dropdown-item<?= $idiom == 'ae' ? ' active' : ''; ?>" data-lang="ar" href="#">
                <i class="flag-icon flag-icon-ae mr-2"></i> <?= lang('app.arabic'); ?>
            </a>
        </li>
        <li>
            <a class="dropdown-item<?=  $idiom == 'gb' ? ' active' : ''; ?>" data-lang="en" href="#">
                <i class="flag-icon flag-icon-gb mr-2"></i> <?= lang('app.english'); ?>
            </a>
        </li>
    </ul>
</div>

<form id="form-change-language" action="<?=  site_url("change_language"); ?>" method="post">
    <input type="hidden" name="lang" id="input-lang" value="en">
    <?= csrf_field(); ?>
</form>