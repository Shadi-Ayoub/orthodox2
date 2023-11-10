<?= $this->extend('auth/layout') ?>

<?= $this->section('title') ?>
    Change Password
<?= $this->endSection() ?>

<?= $this->section('main') ?>

    <div class="login-form">
        <form action="/change-password" method="post">
            <h2 class="text-center">Change Password</h2>
            <?php
                if(isset($message) && trim($message) !== "") {
            ?>
                    <!-- Error Alert -->
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> <?= $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            <?php
                }
            ?>
            <!-- <div class="form-group"> -->
                <div class="input-group mb-3">
                    <!-- <div class="input-group-prepend"> -->
                        <span class="input-group-text">
                            <i class="fa fa-user"></i>
                        </span>
                    <!-- </div> -->
                    <input type="password" class="form-control" name="old-password" placeholder="Old Password" required="required">
                </div>
            <!-- </div> -->
            <!-- <div class="form-group"> -->
                <div class="input-group mb-3">
                    <!-- <div class="input-group-prepend"> -->
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>                    
                    <!-- </div> -->
                    <input type="password" class="form-control" name="new-password" placeholder="New Password" required="required">				
                </div>
            <!-- </div> -->
            <!-- <div class="form-group"> -->
                <div class="input-group mb-3">
                    <!-- <div class="input-group-prepend"> -->
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>                    
                    <!-- </div> -->
                    <input type="password" class="form-control" name="confirm-new-password" placeholder="Confirm New Password" required="required">			
                </div>
            <!-- </div> -->
            <?php
                if($forced == "yes") {
            ?>
                    <input type="hidden" name="forced" value="<?= esc($forced); ?>" />
                    <input type="hidden" name="username" value="<?= esc($username); ?>" />
                    <input type="hidden" name="session" value="<?= esc($session); ?>" />
            <?php
                }
            ?>
            <!-- <div class="form-group"> -->
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary login-btn btn-block">Change Password</button>
            </div>
            <!-- </div> -->
        </form>
    </div>

<?= $this->endSection() ?>
