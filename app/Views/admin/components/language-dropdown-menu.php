<!-- Language Dropdown Menu -->
<?php
    // $user = auth()->user();
    // if($user->lang == 'en'){
    //     $idiom = 'gb';
    // }
    // else {
    //     $idiom = 'ae';
    // }

    $idiom = 'gb';
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