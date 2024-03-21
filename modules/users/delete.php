<?php
if(!defined('_CODE')){
    die('Access denied...');
}

//kiểm tra id trong DB -> tồn tại -> xóa
//Xóa dữ liệu bảng loginToken -> xóa dữ liệu bảng user (kiểm tra xem nó có  đăng nhập ko)

$filterAll = filter();
if(!empty($filterAll['id'])){
    $userId = $filterAll['id'];
    $userDetail = getRows("SELECT * FROM users WHERE id =$userId");
    if($userDetail > 0){
        //Thực hiện xóa
        $deleteToken = delete('tokenLogin',"user_Id = $userId");
        if($deleteToken){
            //Xóa user
            $deleteUser = delete('users',"id = $userId");
            if($deleteUser){
                setFlashData('smg', 'Xóa người dùng thành công');
                setFlashData('smg_type', 'success');  
        }else{
            setFlashData('smg', 'Xóa người dùng thất bại');
            setFlashData('smg_type', 'danger');
        }
    }
    }else{
        setFlashData('smg', 'Người dùng không tồn tại trong hệ thống.');
        setFlashData('smg_type', 'danger');
    }
}else{
    setFlashData('smg', 'Liên kết không tồn tại.');
    setFlashData('smg_type', 'danger');
}
redirect('?module=users&action=list');