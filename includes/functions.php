<!-- các hàm chung của project-->

<?php
if(!defined('_CODE')){
    die('Access denied...');
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function layouts($layoutName ='header', $data = []){
    if(file_exists(_WEB_PATH_TEMPLATES . '/layout/'.$layoutName.'.php')){
        require_once _WEB_PATH_TEMPLATES . '/layout/'.$layoutName.'.php';
    }
}

//Hàm gửi mail
function sendMail($to, $subject, $content){
  
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'comudation.12@gmail.com';                     //SMTP username
    $mail->Password   = 'qvephsqtqgpvhhdw';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('huybuituan21@gmail.com', 'Huy');
    $mail->addAddress($to);     //Add a recipient
   
    //Content
    $mail -> CharSet = "UTF-8";
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $content;
    
    //PHPMAILER SSL certificate verify failed
    //Chứng chỉ SSL hiển thị thông tin quan trọng để xác minh chủ sở hữu trang web và mã hóa lưu lượng truy cập web bằng SSL / TLS, bao gồm khóa công khai, nhà phát hành chứng chỉ và các tên miền phụ được liên kết.
    /*
    Một trang web cần chứng chỉ SSL để giữ an toàn cho dữ liệu người dùng, xác minh quyền sở hữu trang web, ngăn kẻ tấn công tạo phiên bản giả mạo của trang web và giành được lòng tin của người dùng.

Mã hóa: Mã hóa SSL / TLS có thể do ghép nối khóa công khai-riêng tư mà chứng chỉ SSL tạo điều kiện. Khách hàng (chẳng hạn như trình duyệt web) nhận được khóa công khai cần thiết để mở kết nối TLS từ chứng chỉ SSL của máy chủ.

Xác thực: Chứng chỉ SSL xác minh rằng máy khách đang nói chuyện với đúng máy chủ thực sự sở hữu tên miền. Điều này giúp ngăn chặn giả mạo tên miền và các loại tấn công khác.

HTTPS: Quan trọng nhất đối với các doanh nghiệp, chứng chỉ SSL là cần thiết cho địa chỉ web HTTPS. HTTPS là hình thức bảo mật của HTTP và các trang web HTTPS là các trang web có lưu lượng truy cập được mã hóa bằng SSL / TLS.

Ngoài việc bảo mật dữ liệu người dùng khi truyền, HTTPS làm cho các trang web đáng tin cậy hơn từ quan điểm của người dùng. Nhiều người dùng sẽ không nhận thấy sự khác biệt giữa địa chỉ web http:// và địa chỉ web https://, nhưng hầu hết các trình duyệt gắn thẻ các trang web HTTP là "không an toàn" theo những cách đáng chú ý, cố gắng cung cấp động lực để chuyển sang HTTPS và tăng cường bảo mật.

*/ 
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
        );


    $sendMail = $mail->send();
    if($sendMail){
        return $sendMail;
    }
} catch (Exception $e) {
    echo "Gửi mail thất bại. Mailer Error: {$mail->ErrorInfo}";
}
}

//kiểm tra phương thức GET

function isGet(){
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    return true;

}
return false;
}

//Kiểm tra phương thức POST
function isPost(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        return true;
    
    }
    return false;
    }

    //Hàm filter lọc dữ liệu
    function filter(){
        if(isGet()){
            //xử lý dữ liệu trước khi hiển thị ra
           // return $_GET;
            if(!empty($_GET)){
                foreach($_GET as $key => $value){
                    $key = strip_tags($key);
                    if(is_array($value)){
                    $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                        
                    }else{
                    $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }        
        }


        if(isPost()){
            //xử lý dữ liệu trước khi hiển thị ra
           // return $_POST;
            if(!empty($_POST)){
                foreach($_POST as $key => $value){
                    if(is_array($value)){
                        $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS,FILTER_REQUIRE_ARRAY);
                            
                        }else{
                            $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);                        }
                }
            }        
        }

        return $filterArr;
    };


    //Kiểm tra email
    function isEmail($email){
        $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        return $checkEmail;
    }

    //Kiểm tra số nguyên INT
    function isNumberInt($number){
        $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
        return $checkNumber;
    }

    // Kiểm tra kiểu số thực FLoat
    function isNumberFloat($number){
        $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT);
        return $checkNumber;
    }

    //Hàm kiểm tra số điện thoại
    function isPhone($phone){
        $checkZero = false;

        // Điều kiện 1: số đầu tiên là số 0
        if($phone[0] == '0'){
            $checkZero = true;
            $phone = substr($phone, 1);
        }

        // Điều kiện 2: đằng sau có 9 số
        $checkNumber = false;
        if(isNumberInt($phone) && (strlen($phone) == 9)){
            $checkNumber = true;
        }
        if($checkNumber && $checkZero){
            return true;
        }

        return false;
    }

    // thông báo lỗi
    function getSmg($smg, $type = 'success'){
        echo '<div class= "alert alert-'.$type.'">';
        echo $smg;
        echo '</div>';
    }

    //Hàm chuyển hướng
    function redirect($path='index.php'){
        header("Location: $path");
        exit;
    }

    //Hàm thông báo lỗi
    function form_error($fileName, $beforeHtml='', $afterHtml='',$errors)
    {
        return(!empty($errors[$fileName])) ? '<span class = "error">'.reset($errors[$fileName]).'</span>' :null;
    }

    //hàm hiển thị dữ liệu cũ
    function old($fileName, $oldData, $default = null){
        return (!empty($oldData[$fileName])) ? $oldData[$fileName] : $default;

    }

    //Hamf kiểm tra trạng thái đăng nhập
    function isLogin()
    {
        $checkLogin = false;
    if(getSession('tokenLogin')){
        $tokenLogin = getSession('tokenLogin');
        
        //Kiểm tra token có giống DB không
        $queryToken = oneRaw("SELECT user_Id FROM tokenLogin WHERE token = '$tokenLogin' " );
    
        if(!empty($queryToken)){
            $checkLogin = true;
        }else{
            removeSession('tokenLogin');
        }
    }
    return $checkLogin;
    }