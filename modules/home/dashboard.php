<?php
if(!defined('_CODE')){
    die('Access denied...');
}

$data = [
    'pageTitle' => 'Trang Dashboard'
];

layouts('header', $data);
//Kiểm tra trạng thái đăng nhập
    if(!isLogin()){
        redirect ('?module=auth&action=login');
    }
?>
<h1>DASHBOARD</h1>
<?php
layouts('footer');
?>