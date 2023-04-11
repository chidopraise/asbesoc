<?php 
	$page_info = new page_info;
	if($page_info->page_id == '1'){
		include("lib/conn.php");
	}elseif($page_info->page_id == '2'){
		include("../lib/conn.php");
	}elseif($page_info->page_id == '3'){
		include("../../lib/conn.php");
	}
	
	

	class control extends page_info{
		function path($url){
			$this->url = $url;
			if($this->page_id == 1){
				echo $this->url;
			}elseif($this->page_id == 2){
				echo"../".$this->url;
			}elseif($this->page_id == 3){
				echo"../../".$this->url;
			}
		}
		
		
		function selector($option1,$option2,$option0){
			$this->option1 = $option1;
			$this->option2 = $option2;
			$this->option0 = $option0;
			
			if(isset($_SESSION["first_name"])){
				echo $this->option1;
			}elseif(isset($_SESSION["first_name"]) AND $_SESSION["user_id"] == 1){
				echo $this->option2;
			}else{
				echo $this->option0;
			}
		}
		
		
		function home(){
			if(isset($_SESSION["first_name"])){
				$this->path('users/'.$_SESSION['user_name']);
			}else{
				$this->path('menu/discount');
			}
		}
		
		function profile(){
			if(isset($_SESSION["first_name"])){
				echo "<li id='li'><a href='";$this->path('menu/profile');echo"' class='a'>PROFILE</a></li>";
			}else{
				
			}
		}
		
		function profile1(){
			if(isset($_SESSION["first_name"])){
				echo "<li id='li2'><a href='";$this->path('menu/profile');echo"' class='a2'>PROFILE</a></li>";
			}else{
				
			}
		}
		
		function still_on(){
			if(isset($_SESSION["first_name"])){
				header("location:../users/$_SESSION[user_name]");
			}
		}
	}
	$control = new control;
	
	
	
	class fetcher extends conn{
		function fetch($item){
			$this->item = $item;
			$this->conn = mysqli_connect($this->host,$this->user,$this->pass,$this->db);
			$this->sql = "SELECT * FROM users WHERE id = '$_SESSION[user_id]'";
			$this->retval = mysqli_query($this->conn,$this->sql);
			if(mysqli_num_rows($this->retval)){
				$row = mysqli_fetch_assoc($this->retval);
				if($this->item == 'first_name'){
					echo $row["f_name"];
				}elseif($this->item == 'last_name'){
					echo $row["l_name"];
				}elseif($this->item == 'middle_name'){
					echo $row["o_name"];
				}elseif($this->item == 'user_name'){
					echo $row["u_name"];
				}elseif($this->item == 'email'){
					echo $row["email"];
				}elseif($this->item == 'phone'){
					echo $row["phone"];
				}elseif($this->item == 'pass'){
					echo $row["password"];
				}elseif($this->item == 'address'){
					echo $row["address"];
				}elseif($this->item == 'sex'){
					echo $row["sex"];
				}elseif($this->item == 'country'){
					echo $row["country"];
				}elseif($this->item == 'state'){
					echo $row["state"];
				}elseif($this->item == 'd_o_b'){
					echo $row["date_of_birth"];
				}elseif($this->item == 'postal_code'){
					echo $row["postal_code"];
				}elseif($this->item == 'l_g_a'){
					echo $row["lga"];
				}elseif($this->item == 'r_code'){
					echo $row["r_code"];
				}elseif($this->item == 'profession'){
					echo $row["profession"];
				}elseif($this->item == 'marital_status'){
					echo $row["marital_status"];
				}elseif($this->item == 'religion'){
					echo $row["religion"];
				}elseif($this->item == 'nk_name'){
					echo $row["nk_nama"];
				}elseif($this->item == 'nk_phone'){
					echo $row["nk_phone"];
				}elseif($this->item == 'acc_number'){
					echo $row["acc_number"];
				}elseif($this->item == 'acc_name'){
					echo $row["acc_name"];
				}elseif($this->item == 'bank_name'){
					echo $row["bank_name"];
				}elseif($this->item == 'role'){
					echo $row["role"];
				}elseif($this->item == 'date'){
					echo $row["date"];
				}elseif($this->item == 'profile_pics'){
					echo $row["profile_pics"];
				}elseif($this->item == 'profile_pics1'){
					if($row["profile_pics"] == '../images/media/' OR $row["profile_pics"] == ''){
						echo"../images/img.jpg";
					}else{
						echo $row["profile_pics"];
					}
				}
			}
		}
	}
	
	$fetcher = new fetcher;
?>