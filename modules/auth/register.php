<!-- Đăng ký -->
<?php
if(!defined('_CODE')){
    die('Access denied...');
}
if(isPost()){
    $filterAll = filter();
    //mảng chứa các lôĩ
    $errors =[];
    //Validate fullname: Bắt buộc phải nhập, min = 5 ký tự
    if(empty($filterAll['fullname'])){
        $errors['fullname']['required'] = 'Họ tên bắt buộc phải nhập';
    }else{
        if(strlen($filterAll['fullname'] ) < 5){
            $errors['fullname']['min'] = 'Họ tên phải có ít nhất 5 ký tự';
        }
    }
    //Email Validate:  bắt buộc phải nhập, đúng định dạng mail, kiểm tra email đã tồn tại trong cơ sở dữ liệu chưa
    if(empty($filterAll['email'])){
        $errors['email']['required'] = 'Email bắt buộc phải nhập';
    }else{
        $email = $filterAll['email'];
        $sql  = "SELECT id FROM users WHERE email = '$email'";
        if(getRows($sql) > 0 ){
            $errors['$email']['unique'] = 'Email đã tồn tại';
        }
    }
    //Validate số điện thoại: bắt buộc nhập, số có đúng định dạng không?
if(empty($filterAll['phone'])){
    $errors['phone']['required'] = 'Số điện thoại bắt buộc phải nhập';
}else{
    if(!isphone($filterAll['phone'])){
        $errors['phone']['isPhone'] = 'Số điện thoại không hợp lệ';
    }
}
//Validate password: bắt buộc nhập, từ 8 ký tự trở lên;
if(empty($filterAll['password'])){
    $errors['password']['required'] = 'mật khẩu bắt buộc phải nhập';
}else{
   if(($filterAll['password']) < 8){
    $errors['password']['min'] = 'Mật khẩu phải nhiều hơn 8 ký tự!';
   }
}
//Validate password_confirm: bắt buộc phải nhập, giống password
if(empty($filterAll['password_confirm'])){
    $errors['password_confirm']['required'] = 'Bạn phải nhập lại mật khẩu';
}else{
   if((strlen($filterAll['password']))  != (strlen($filterAll['password_confirm']))){
    $errors['password_confirm']['match'] = 'Mật khẩu bạn nhập chưa  đúng!';
   }
}
    if(empty($errors)){
        $activeToken = sha1(uniqid().time());

        $dataInsert=[
            'fullname' => $filterAll['fullname'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'password' => password_Hash($filterAll['password'], PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'create_at' => date('Y-m-d H:i:s')
        ];
       
        $insertStatus = insert('users',$dataInsert);
        if($insertStatus){
        
           //Tạo link kích hoạt
           $linkActive = _WEB_HOST . '?module=auth&action=active&token='. $activeToken;
        
        
        //thiết lập gửi mail
            $subject = $filterAll['fullname']. 'Vui lòng kích hoạt tài khoản!';
            $content = 'Chào '.$filterAll['fullname'].'.</br>';
            $content .= ' Vui lòng click vào link để kích hoạt tài khoản: </br>';
            $content .= $linkActive. '</br>';
            $content .= 'Trân trọng cảm ơn!';

            //Tiến hành gửi mail
            $senMail = sendMail($filterAll['email'], $subject, $content);
            if($senMail){
                setFlashData('smg','Đăng ký thành công, Vui lòng kiểm tra email để kích hoạt tài khoản!!');
                setFlashData('smg_type','success');
            }else{
                setFlashData('smg','Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                setFlashData('smg_type','danger');

            }
        } else{
            setFlashData('smg','Đăng ký không thành công!!');
            setFlashData('smg_type','danger');
        }  
        redirect('?module=auth&action=register');
    }else{
      
        setFlashData('smg','Vui lòng kiểm tra lại dữ liệu!!');
        setFlashData('smg_type','danger');
        setFlashData('errors',$errors);
        setFlashData('old', $filterAll);
        redirect('?module=auth&action=register');
    }
}
$data = [
    'pageTitle' => 'Đăng ký tài khoản'];

layouts('header-login', $data);

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>
<div class="row">
    <div class="col-4" style="margin: 50px auto;">
    <h2 class="text-center text-uppercase">Đăng ký người dùng</h2>
        <?php 
            if(!empty($smg)){
               getSmg($smg,$smg_type);
        }
        ?>
        <form action="" method="post">
        <div class="form-group mg-form">
                <label for="">Họ tên</label>
                <input name="fullname" type="fullname" class="form-control" placeholder="Họ tên"  value="<?php
                    echo old('fullname', $old);
                ?>">
                <?php
                    echo(!empty($errors['fullname'])) ? '<span class="error">'.reset($errors['fullname']).'</span>' : null;
                ?>
            </div>
            <div class="form-group mg-form">
                <label for="">Email</label>
                <input name="email" type="email" class="form-control" placeholder="Địa chỉ email" value="<?php
                  echo old('email', $old);
                ?>">
                <?php
                    echo form_error('email','<span class="error">','</span>',$errors);
                ?>
            </div>
            <div class="form-group mg-form">
                <label for="">Số điện thoại</label>
                <input name="phone" type="number" class="form-control" placeholder="Số điện thoại" value="<?php
                  echo old('phone', $old);
                ?>">
                <?php
                    echo form_error('phone','<span class="error">','</span>',$errors);
                ?>
            </div>
            <div class="form-group mg-form">
                <label for="">Mật khẩu</label>
                <input name="password" type="password" class="form-control" placeholder="Mật khẩu">
                <?php
                    echo form_error('password','<span class="error">','</span>',$errors);
                ?>
            </div>
            <div class="form-group mg-form">
                <label for="">Nhập lại mật khẩu</label>
                <input name="password_confirm" type="password" class="form-control" placeholder="Nhập lại Mật khẩu">
                <?php
                    echo form_error('password_confirm','<span class="error">','</span>',$errors);
                ?>
            </div>
            <button class="mg-btn btn btn-primary btn-block ">Đăng ký</button>
            <hr>
            <p class="text-center"><a href="?module=auth&action=login">Đăng nhập </a></p>
        </form>
    </div>
</div>
<?php
   layouts('footer-login');
?>
<!-- Hàm old dùng đẻ chứa dữ liệu cũ-->
