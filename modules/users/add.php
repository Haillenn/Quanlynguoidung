<!-- thêm người dùng -->
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

        $dataInsert=[
            'fullname' => $filterAll['fullname'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'password' => password_Hash($filterAll['password'], PASSWORD_DEFAULT),
            'status' => $filterAll['status'],
            'create_at' => date('Y-m-d H:i:s')
        ];
       
        $insertStatus = insert('users',$dataInsert);
        if($insertStatus){
                setFlashData('smg','Thêm người dùng mới thành công!!');
                setFlashData('smg_type','success');
                redirect('?module=users&action=list');

            }else{
            setFlashData('smg','hệ thống đang lỗi vui lòng thử lại sau!!');
            setFlashData('smg_type','danger');
        }  
        redirect('?module=users&action=add');
    }else{
      
        setFlashData('smg','Vui lòng kiểm tra lại dữ liệu!!');
        setFlashData('smg_type','danger');
        setFlashData('errors',$errors);
        setFlashData('old', $filterAll);
        redirect('?module=users&action=add');
    }
}
$data = [
    'pageTitle' => 'Thêm người dùng'];

layouts('header-login', $data);

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>
<div class="container">
    <div class="row" style="margin: 50px auto;">

    <h2 class="text-center text-uppercase">Thêm người dùng</h2>
        <?php 
            if(!empty($smg)){
               getSmg($smg,$smg_type);
        }
        ?>
        <form action="" method="post">
            <div class="row">
                <div class="col">
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
                </div>
                <div class="col">
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
            <div class="form-group">
                <label for="">Trạng thái</label>
                <select name="status" id="" class="form-control">
                    <option value="0" <?php echo (old('status', $old) == 0) ? 'selected' : false; ?>>Chưa kích hoạt</option>
                    <option value="1" <?php echo (old('status', $old) == 1) ? 'selected' : false; ?>>Đã kích hoạt</option>
                        </select>

                    </div>
                </div>
            </div>
            <button type="submit" class="mg-btn btn btn-primary btn-block ">Thêm người dùng</button>
            <a href="?module=users&action=list" class="mg-btn btn btn-success btn-block ">Quay lại</a>
            <hr>
        </form>
    </div>

</div>
<?php
   layouts('footer-login');
?>

<!-- Hàm old dùng đẻ chứa dữ liệu cũ-->
