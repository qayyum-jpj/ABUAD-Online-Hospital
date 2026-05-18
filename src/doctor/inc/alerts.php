<div class="<?php if(isset($page) && $page == 'login'){ echo 'd-block'; }else{ echo 'd-inline-block'; } ?> mt-3">
    <?php if($smsg): ?>
    <div class="alert msg-alert border-success text-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i>
        <?= $smsg ?>
    </div>
    <?php endif ?>
    <?php if($imsg): ?>
    <div class="alert msg-alert border-info text-info alert-dismissible fade show" role="alert">
        <i class="bi bi-info-circle"></i>
        <?= $imsg ?>
    </div>
    <?php endif ?>
    <?php if($emsg): ?>
    <div class="alert msg-alert border-danger text-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle"></i>
        <?= $emsg ?>
    </div>
    <?php endif ?>
    <?php if($prompt): ?>
    <div class="alert border-warning text-warning alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i>
        <?= $promptMsg ?>
        <form action="" method="post">
            <button class="btn btn-sm btn-outline-success" type="submit" name="doAction">Yes</button>
            <a href="<?= $pgURL ?>" class="btn btn-sm btn-outline-danger">No</a>
        </form>
    </div>
    <?php endif ?>
</div>
