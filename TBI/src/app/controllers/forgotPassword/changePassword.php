<?php

if (!isset($_GET['id'])) {
    show404();
}

$userInfo = getById(intval($_GET['id']), 'users');
$title = 'Forgot password';
require('src/app/views/forgotPassword/changePassword.view.php');