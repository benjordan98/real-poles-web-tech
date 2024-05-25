<?php $loggedIn = User::isLoggedIn(); ?>

<p>[
    <a href="<?= BASE_URL . "allpolls" ?>"> All polls </a>
    <?php if ($loggedIn) : ?>
        <a href="<?= BASE_URL . "results" ?>"> My polls </a>
    <?php endif; ?>
    <a href="<?= BASE_URL . "poll/add" ?>"> Add poll </a>
    <a href="<?= BASE_URL . "user/login" ?>"> Login </a>
    <a href="<?= BASE_URL . "user/register" ?>"> Register </a>
    <?php if ($loggedIn) : ?>
        <a href="<?= BASE_URL . "user/logout" ?>"> Logout </a>
    <?php endif; ?>
    ]
</p>