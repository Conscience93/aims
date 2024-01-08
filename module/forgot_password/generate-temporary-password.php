<head>
  <!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    /* Custom style for the Sweet Alert container */
    .swal2-modal {
    font-size: 45px;
  }
  </style>
</head>
<body>
  <!-- Add a div element to hold the SweetAlert -->
  <div id="sweet-alert-container"></div>
</body>

<?php
include_once "../../include/db_connection.php";
session_start();
date_default_timezone_set("Asia/Kuching");

if(isset($_POST["phone"]) && (!empty($_POST["phone"]))){
  $phone = $_POST["phone"];
  // Remove any non-digit characters from the phone number
  $phone = preg_replace("/[^0-9]/", "", $phone);

  if (!$phone) {
    //check phone number
    echo "<script>
      Swal.fire({
        icon: 'error',
        title: 'Invalid phone number!',
        text: 'Please type a valid phone number!!',
        target: 'body'
      }).then(function() {
        setTimeout(function() {
          window.location.href = '../../index.php';
        }, 500);
      });
    </script>";
  }else{
    //check if phone number available in the club member table
    $sel_query = "SELECT phone FROM aims_user WHERE phone='$phone'";
    $results = mysqli_query($con,$sel_query);
    $row = mysqli_num_rows($results);
    //if no record
    if ($row==0){
      echo "<script>
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'Phone number not registered!',
          target: 'body'
        }).then(function() {
          setTimeout(function() {
            window.location.href = '../../index.php';
          }, 5000);
        });
      </script>";
    }else{
      //insert data to the temporary token
      $expDate = date("Y-m-d H:i:s", strtotime('+10 minute'));
      $addKey = uniqid(rand(),1);
      $key = md5($addKey.$phone);
      $sql ="INSERT INTO password_reset_temp (`phone`, `key`, `expDate`) VALUES ('$phone', '$key', '$expDate');";
      if (mysqli_query($con, $sql)) {
        //send whatsapp
        // Waboxapp API credentials
        $waboxapp_token = "2d4dae3b57e7fed7954dfc4739551a55625523e740402";
        $waboxapp_api_url = "https://www.waboxapp.com/api/send/chat";
        // User details
        $random = date("Ymdhis") . md5(uniqid(rand(), true));
        $custom_uid = $random;
        $uid = "60107099596";
        $user_phone_number = '6' . $phone;


        $text = "Dear Customers, we have received your password reset request.\n\nPlease use the link below to reset your password.\nhttp://localhost/aims/forgot_password/reset-password.php ?key=" . $key . "&phone=" . $phone . "&action=reset\n\n*This is an auto-generated message. Do not reply.*";

    //$url = "https://www.google.com";

    //$postField = 'token='.$waboxapp_token.'&uid='.$uid.'&to='.$user_phone_number.'&custom_uid='.$custom_uid.'&text='.$text;
    $postField = array(
        "token" => $waboxapp_token,
        "uid" => $uid,
        "to" => $user_phone_number,
        "custom_uid" => $custom_uid,
        "text" => $text 
    );

    // Send the message
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://www.waboxapp.com/api/send/chat"); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
    curl_setopt($ch, CURLOPT_POST, 1); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postField); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_MAXREDIRS, 5); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 20); 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 25); 
    $result = curl_exec($ch); 
    $info = curl_getinfo($ch); 
    // echo $result;
    curl_close ($ch);

    if($result){
        echo "<script>
            Swal.fire({
              icon: 'success',
              title: 'Change password request received. Please check your whatsapp.',
              showConfirmButton: false,
              timer: 3500,
              target: 'body'
            }).then(function() {
              setTimeout(function() {
                window.location.href = '../../index.php';
              }, 500);
            });
          </script>";
        } else {//whatsapp not sent
          echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Something went wrong. Please try again.',
              showConfirmButton: false,
              timer: 3500,
              target: 'body'
            }).then(function() {
              setTimeout(function() {
                window.location.href = '.../../index.php';
              }, 500);
            });
          </script>";
        }
      }else{//something wrong when insert to aims_password_reset_temp
        echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'Something went wrong. Please try again.',
            showConfirmButton: false,
            timer: 3500,
            target: 'body'
          }).then(function() {
            setTimeout(function() {
              window.location.href = '../../index.php';
            }, 500);
          });
        </script>";
      }
    }
  }
}else{//not valid phone number
  echo "<script>
    Swal.fire({
      icon: 'error',
      title: 'Invalid phone number!',
      text: 'Please type a valid phone number!!',
      showConfirmButton: false,
      timer: 3500,
      target: 'body'
    }).then(function() {
      setTimeout(function() {
        window.location.href = '../../index.php';
      }, 500);
    });
  </script>";
}