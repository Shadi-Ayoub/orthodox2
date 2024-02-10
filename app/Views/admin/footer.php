<?php
    $utility = service('utility');
?>
<nav id="dashboard-footer" class="navbar fixed-bottom bg-body-tertiary">
  <div class="container-fluid">
    <!-- Default to the left -->
    <div id="copyright" class="d-none d-sm-block">
      <?= lang('app.copyright'); ?> &copy; <?= date("Y"); ?> <?= anchor('/', lang('app.faith_hubspot')); ?>. <?= lang('app.all_rights_reserved'); ?>.
    </div>

    <!-- To the right -->
    <div id="dashboard-version" class="d-none d-sm-block">
      <?= lang('app.version'); ?>:<?= $utility->print_version(); ?>
    </div>
  </div>
</nav>