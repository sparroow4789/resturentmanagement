<?php

class DB {
	
	private $db_name = 'besthote_demo_resturent_managemet';
	private $db_user = 'besthote_amazoft';
	private $db_pass = 'amazoft2020';
	private $db_host = 'localhost';
	private $connect_db = null;



	function __construct()
	{

		if($this->connect_db==null || !$this->connect_db->ping()){
			$this->connect_db=new mysqli( $this->db_host, $this->db_user, $this->db_pass, $this->db_name );

			
					if ( mysqli_connect_errno() ) {
					printf("Connection failed: %s", mysqli_connect_error());
					exit();
					}

		}
		
	}




	public function connect() {
		return $this->connect_db;
	}


	public function closeConnection(){
		$this->connect_db->close();
	}








}