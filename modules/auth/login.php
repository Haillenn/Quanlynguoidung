<!-- Đăng nhập -->
<?php
if(!defined('_CODE')){
    die('Access denied...');
}
$data = [
    'pageTitle' => 'Đăng nhập tài khoản'];

 layouts('header-login', $data);
 
 //Kiểm tra trạng thái đăng nhập
if(isLogin()){
    redirect ('?module=home&action=dashboard');
}
if(isPost()){
    $filterAll = filter();
    if(!empty(trim($filterAll['email'])) && !empty(trim($filterAll['password'])))
    
    // kiểm tra đăng nhập 
    {
    $email = $filterAll['email'];
    $password = $filterAll['password'];

    //Truy vấn lấy thông tin users theo email
    $userQuery = oneRaw("SELECT password FROM users WHERE email = '$email'");
    
    if(!empty($userQuery)){
        $passwordHash = $userQuery['password'];
        $userId = $userQuery['id'];
        if(password_verify($password, $passwordHash)){
            
            /*
             login token chứa token: khi người dùng nhập pass chính xác đăng nhập hệ thống thì sẽ xuất hiện
             1 token được sinh ra và insert vào bảng, token tượng trưng cho user đang login, khi log out sẽ xóa token.
             */
            // Tạo tokenlogin
            
            $tokenLogin = sha1(uniqid().time());

            //Insert vào bảng loginToken.
            $dataInsert = [
                'user_Id' => $userId,
                'token' => $tokenLogin,
                'create_at' => date('Y-m-d H:i:s')
            ];
            
            $insertStatus = insert('tokenLogin', $dataInsert);
            if($insertStatus){
                //Insert thành công

                //Lưu loginToken vào session -> tiện cho việc kiểm tra xem người dùng có đăng nhập không
                setSession('tokenLogin', $tokenLogin);

                redirect ('?module=home&action=dashboard');

            }else{
                setFlashData('msg', 'không thể đăng nhập vui lòng thử lại sau!');
                setFlashData('msg_type', 'danger');
            }

        }else{
            setFlashData('msg', 'Mật khẩu không chính xác!');
            setFlashData('msg_type', 'danger');
          
        }
    }else{
        setFlashData('msg', 'Email không tồn tại!');
        setFlashData('msg_type', 'danger');
        
    }
    }else{
        setFlashData('msg', 'Vui lòng nhập email và mật khẩu!');
        setFlashData('msg_type', 'danger');
        
    }
    redirect ('?module==auth&action=login');
}

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');

?>

<div class="row">
    <div class="col-4" style="margin: 50px auto;">
    <h2 class="text-center text-uppercase">Đăng nhập người dùng</h2>
    <?php 
    if(!empty ($msg)){
      getSmg($msg, $msg_type );
    }
    ?>
        <form action="" method="post">
       
            <div class="form-group mg-form">
                <label for="">Email</label>
                <input name="email" type="email" class="form-control" placeholder="Địa chỉ email">
            </div>
           
            <div class="form-group mg-form">
                <label for="">Mật khẩu</label>
                <input name="password" type="password" class="form-control" placeholder="Mật khẩu">
            </div>
        

            <button class="mg-btn btn btn-primary btn-block ">Đăng nhập</button>
            <hr>
            <p class="text-center"><a href="?module=auth&action=forgot">Quên mật khẩu </a></p>
            <p class="text-center"><a href="?module=auth&action=register">Đăng ký </a></p>

        </form>
    </div>

</div>

<?php
   layouts('footer-login');
?>