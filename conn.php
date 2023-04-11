<?php
	class conn{
		public $host = "localhost:3306";
		public $user = "root";
		public $pass = "";
		public $db   = "asbesoc";
		
		function connect(){
			mysqli_connect($this->host,$this->user,$this->pass,$this->db);
		}
	}
?>