<!-- Đăng xuất -->
<?php
if(!defined('_CODE')){
    die('Access denied...');
}
if(isLogin()){
    $token = getSession('tokenLogin');
    delete('tokenLogin', "token='$token'");
    removeSession('tokenLogin');
    redirect('?module=auth&action=login');
}