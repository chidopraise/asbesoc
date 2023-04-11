<?php
session_start();
//ini_set("SMTP","mail.asbesoc-vpad.org");
//ini_set("smtp_port","25");
//ini_set('sendmail_from','asbesoc-vpad.org');



include("../lib/conn.php");
						
/////////////////////useful public variables///////////////////////////////////////
date_default_timezone_set("africa/lagos");
$date = date("D, d/m/Y  h:i:s");

	
///////////////////////////////PROCESSOR///////////////////////////////////////
class handler extends conn{
	function query($order,$sql){
		$this->order = $order;
		$this->sql   = $sql;
		$this->conn = mysqli_connect($this->host,$this->user,$this->pass,$this->db);
		
		if($this->order == 'table'){
			if(mysqli_query($this->conn,$this->sql)){
				echo"Your Table Has Been Succesfully Created";
			}else{
				echo"Your Table Could Not Be Created".mysqli_error($this->conn);
			}
		}elseif($this->order == 'fix'){
			if(mysqli_query($this->conn,$this->sql)){
				echo"Your Table Has Been Succesfully Fixed As You Want It";
			}else{
				echo"Your Table Could Not Be Fixed".mysqli_error($this->conn);
			}
		}elseif($this->order == 'sign_up'){
			if(mysqli_query($this->conn,$this->sql)){
				echo"<script type='text/javascript'> alert('Your Account Has Been Created And An Email Confirmation Message Has Been Sent To Your Email Address!!!'); window.location.href = '../menu/discount'; </script>";
			}else{
				echo"<script type='text/javascript'> alert('Your Account Your Account Could Not Be Created Due To Technical Issue Or Empty Field In The Form ???'); window.location.href = '../menu/discount'; </script>".mysqli_error($this->conn);
			}
			////////the login handler////////
		}elseif($this->order == 'sign_in'){
			$retval = mysqli_query($this->conn,$this->sql);
			if(mysqli_num_rows($retval)){
				$row = mysqli_fetch_assoc($retval);
				$_SESSION["user_id"] = $row["id"];
				$_SESSION["first_name"] = $row["f_name"];
				$_SESSION["last_name"] = $row["l_name"];
				$_SESSION["middle_name"] = $row["o_name"];
				$_SESSION["user_name"] = $row["u_name"];
				$_SESSION["email"] = $row["email"];
				$_SESSION["phone"] = $row["phone"];
				$_SESSION["pass"] = $row["password"];
				$_SESSION["address"] = $row["address"];
				$_SESSION["sex"] = $row["sex"];
				$_SESSION["role"] = $row["role"];
				
				echo"<script type='text/javascript'> alert('Welcome $_SESSION[first_name]  $_SESSION[last_name], It\'s Nice See You Online. !!!'); window.location.href = '../users/$_SESSION[user_name]'; </script>";
			}else{
				echo"<script type='text/javascript'> alert('This User Does Not Exist, Please Check Your Login Details And Try Again Or Click The REGISTER Button To Create An Account !!!'); window.location.href = '../menu/discount'; </script>".mysqli_error($this->conn);
			}
			//////////////Profile Update Handler////////////////////
		}elseif($this->order == 'update_profile'){
			if(mysqli_query($this->conn,$this->sql)){
				echo"<script type='text/javascript'> alert('Your Profile Details Has Been Updated Succesfullly !!!'); window.location.href = '../menu/profile'; </script>";
			}else{
				echo"<script type='text/javascript'> alert('Your Profile Details Could Not Be Updated Due To Technical Issue Or Empty Field In The Form ???'); window.location.href = '../menu/profile'; </script>".mysqli_error($this->conn);
			}
		}elseif($this->order == 'update_pp'){
			if(mysqli_query($this->conn,$this->sql)){
				echo"<script type='text/javascript'> alert('Your Profile Photo Has Been Changed Succesfullly !!!'); window.location.href = '../users/$_SESSION[user_name]'; </script>";
			}else{
				echo"<script type='text/javascript'> alert('Your Profile Photo Could Not Be Changed Due To Technical Issue Or Unacceptable Image ???'); window.location.href = '../users/$_SESSION[user_name]'; </script>".mysqli_error($this->conn);
			}
		}
	}
}

$handler = new handler;



////////////////////////////FIXER/REPIARER/////////////////////////////////////////
$fix = "ALTER TABLE users MODIFY o_name VARCHAR(30) NULL";
$handler->query("fix",$fix);

$fix1 = "ALTER TABLE users MODIFY country VARCHAR(30) NULL";
$handler->query("fix",$fix1);

$fix2 = "ALTER TABLE users MODIFY state VARCHAR(30) NULL";
$handler->query("fix",$fix2);

$fix3 = "ALTER TABLE users ADD role VARCHAR(40) NULL";
$handler->query("fix",$fix3);

$fix4 = "ALTER TABLE users ADD date VARCHAR(40) NOT NULL";
$handler->query("fix",$fix4);

$fix5 = "ALTER TABLE users ADD profile_pics VARCHAR(100) NULL";
$handler->query("fix",$fix5);





/////////////////////////EXECUTOR/CALLER////////////////////////////////////////


////////////// sign up handler ///////////////////////////////////////////
if(isset($_POST["register"])){
	if($_POST["pass"] == $_POST["c_pass"]){
		if(!empty($_POST["first_name"]) OR !empty($_POST["last_name"]) OR !empty($_POST["user_name"]) OR !empty($_POST["email"]) OR !empty($_POST["pass"])){
			$sign_up = "INSERT INTO users(f_name,l_name,o_name,u_name,email,phone,password,address,sex,role,date) VALUES('$_POST[first_name]','$_POST[last_name]','$_POST[middle_name]','$_POST[user_name]','$_POST[email]','$_POST[phone]','$_POST[pass]','$_POST[address]','$_POST[sex]','$_POST[role]','$date')";
			
			$username = $_POST['user_name'];
			$target_file = "../users/$username.php";
			$target_file1 = "../users/x$username.php";
		
					if(file_exists($target_file)){
						die("<script> alert('the user name you used has been taken please pick another one and try again'); window.location.href='../menu/discount';</script>");
					}else{
						$handler->query("sign_up",$sign_up);
						$file = fopen( $target_file, "w" );
						fwrite( $file,"<?php include('user.php'); ?>");
						fclose( $file );
						
						$file = fopen( $target_file1, "w" );
						fwrite( $file,"<?php unlink('".$target_file1."'); echo\"<script> alert('CONGRATULATION: Your Email Has Been Confirmed, You Can Now Login !!!'); window.location.href='../menu/discount'; </script>\";?>");
						fclose( $file );
						
						$to = $_POST['email'];
						$subject = "Email Address Verification";
						$message = "<p><h2>Congratulations: </h2> ".$_POST['first_name']." ".$_POST['last_name']." Your Account Has Been Created And You Are Now a Registered ".$_POST['role']." in Asbesoc-vpad.org. Please Click On The Link Below To Verify Your Email Address And Also Complete Your Rigistration</p>";
						$message .= "<p><a href='https://www.asbesoc-vpad.org/asbesoc/users/x".$username."'>click here to verify your email</a></p>";
						$header = "From:abrahamlivinus@gmail.com \r\n";
						$header .= "Cc:abrahamlivinus@gmail.com \r\n";
						$header .= "MIME-Version: 1.0\r\n";
						$header .= "Content-type: text/html\r\n";
						$retval = mail ($to,$subject,$message,$header);
					}
			
		}else{
			echo"<script type='text/javascript'> alert('Please Fill All The Form Fields!!!'); window.location.href = '../menu/discount';</script>";
		}
		
	}else{
		echo"<script type='text/javascript'> alert('Your Password Doesn't Match, Check And Try Again!!!'); window.location.href = '../menu/discount';</script>";
	}
}






/////////////////////// sign in handler ///////////////////////////////////
if(isset($_POST["login"])){
	if(!empty($_POST["email"]) AND !empty($_POST["pass"])){
		$sign_in = "SELECT * FROM users WHERE email = '$_POST[email]' && password = '$_POST[pass]' OR u_name = '$_POST[email]' && password = '$_POST[pass]' OR phone = '$_POST[email]' && password = '$_POST[pass]'";
		$handler->query("sign_in",$sign_in);
	}else{
		echo"<script type='text/javascript'> alert('Your Login Form Field Is Not Filled, Please Complete Your Form And Try Again......'); window.location.href = '../menu/discount'; </script>";
	}
}



//////////////////////Profile Update Handler/////////////////////////////
if(isset($_POST["update"])){
	if(!empty($_POST["pass"]) && !empty($_POST['n_pass'])){
		if($_POST["pass"] == $_SESSION["pass"]){
			$update_profile = "UPDATE users SET f_name='$_POST[first_name]', l_name='$_POST[last_name]', o_name='$_POST[middle_name]', email='$_POST[email]', phone='$_POST[phone]', password='$_POST[n_pass]', address='$_POST[address]', sex='$_POST[sex]', country='$_POST[country]', state='$_POST[state]', date_of_birth='$_POST[d_o_b]', postal_code='$_POST[postal_code]', lga='$_POST[l_g_a]', profession='$_POST[profession]', marital_status='$_POST[marital_status]', religion='$_POST[religion]', nk_nama='$_POST[n_k_n]', nk_phone='$_POST[n_k_p]', acc_number='$_POST[acc_number]', acc_name='$_POST[acc_name]', bank_name='$_POST[bank_name]', role='$_POST[role]'";
			
			$handler->query("update_profile",$update_profile);
		}else{
			echo"<script type='text/javascript'> alert('INCORRECT OLD PASSWORD, PLEASE CONFIRM YOUR OLD PASSWORD AND TRY AGAIN ..'); window.location.href = '../menu/profile'; </script>";
		}
	}else{
		$update_profile = "UPDATE users SET f_name='$_POST[first_name]', l_name='$_POST[last_name]', o_name='$_POST[middle_name]', email='$_POST[email]', phone='$_POST[phone]', address='$_POST[address]', sex='$_POST[sex]', country='$_POST[country]', state='$_POST[state]', date_of_birth='$_POST[d_o_b]', postal_code='$_POST[postal_code]', lga='$_POST[l_g_a]', profession='$_POST[profession]', marital_status='$_POST[marital_status]', religion='$_POST[religion]', nk_nama='$_POST[n_k_n]', nk_phone='$_POST[n_k_p]', acc_number='$_POST[acc_number]', acc_name='$_POST[acc_name]', bank_name='$_POST[bank_name]', role='$_POST[role]'";
			
		$handler->query("update_profile",$update_profile);
	}
}




//////////////////////profile pics Handler///////////////////////////////////
if(isset($_POST["pps"])){
    $path = "../images/media/".$_FILES["filetoupload"]["name"];
    $target_dir = "../images/media/";
    $target_file = $target_dir.basename($_FILES["filetoupload"]["name"]);
    $uploadok = 1;
    $imagefiletype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    ///////////////check if file is an actual image///////////////////////////////////////
    if(isset($_POST["pps"])){
        $check = getimagesize($_FILES["filetoupload"]["tmp_name"],$target_dir);
        if($check !== false){
            "file is an image -".$check["mime"]
            .".";
            $uploadok= 1;
        }else{
            echo "file is not an image.";
            $uploadok = 0;
        }
    }
    //////////////////////////check if file already exist//////////////////////////
    if(file_exists($target_file)){
        $update_pp = "UPDATE users SET profile_pics = '$path' WHERE id = '$_SESSION[user_id]'";
		$select = "SELECT  profile_pics FROM users WHERE id= '$_SESSION[user_id]'";
		if(mysqli_num_rows(mysqli_query($conn,$select))){
			$handler->query("update_pp",$update_pp);
		}else{
			$insert = "UPDATE users SET profile_pics = '$path' WHERE id = '$_SESSION[user_id]'";
			$handler->query("update_pp",$insert);
		}
		
    }else {
        //////////////////////check file size////////////////
        if ($_FILES["filetoupload"]["size"] > 1000000) {
            echo "sorry, your file is too large.";
            $uploadok = 0;
        }
        ////////////////////////////////allow certain file format//////////////////////////
        if ($imagefiletype != "jpg" && $imagefiletype != "png" && $imagefiletype != "jpeg" && $imagefiletype != "ico" && $imagefiletype != "gif") {
            echo "sorry, only JPG,JPEG,png,& GIF files are allowed.";
            $uploadok = 0;
        }
        ////////// check if $uploadok is set to 0 by an error/////////////////////////////
        if ($uploadok == 0) {
            echo "your file was not uploaded.";
        } else {

            ///////////////////////if everything is ok,try uploading the file ///////////////////

            if (move_uploaded_file($_FILES["filetoupload"]['tmp_name'], $target_file)) {
                $update_pp = "UPDATE users SET profile_pics = '$path' WHERE id = '$_SESSION[user_id]'";
				$select = "SELECT  profile_pics FROM users WHERE id= '$_SESSION[user_id]'";
				if(mysqli_num_rows(mysqli_query($conn,$select))){
					$handler->query("update_pp",$update_pp);
				}else{
					$insert = "UPDATE users SET profile_pics = '$path' WHERE id = '$_SESSION[user_id]'";
					$handler->query("update_pp",$insert);
				}
            } else {
                "sorry, there was an error uploading your file.";
            }
        }
    }
}



 ?>