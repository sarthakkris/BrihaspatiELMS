<?php

		/////******************CONTROLLER**************/////

//session_start(); 
class Mobile extends CI_Controller 
	{
		 function __construct() 
		{
			parent::__construct();
			
			//*****loading needed libraries******
			
			$this->load->helper('form','url');
			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->model('login_model');
		}
		
		public function index()
		{
			/*****if user logged in,load session to the page leavemgmt.php*********/
			
			if(!empty($this->session->userdata['username']))
			{
				//print_r("helllo");die;
			$this->load->view('mobile/leavemgmt');
			}
			else//*****otherwise go to login page*******
			{
				$this->load->view('mobile/loginview');
			//print_r("helllo");die;
			}
		}
		
		public function m_auth()
		{
			$combid=$this->input->post('credentials');
			//$this->logger->write_logmessage("insert"," after combid" );
			$parts=explode(",",$combid);
			
			//$this->logger->write_logmessage("insert"," after parts" );
			
			$data = array(
					'username' => $parts[0],
					'password' => $parts[1]
					);
					
					
					
			/*$this->logger->write_logmessage("insert",$data );		
			$result = $this->login_model->isduplicatemore('edrpuser',$data);*/
			
			
		
			$result = $this->login_model->validate_user($data);

			
			
			/*$this->logger->write_logmessage("insert","   ***hello   " );		
			$this->logger->write_logmessage("insert",$result );	
			$this->logger->write_logmessage("insert",$parts[0] );
			$this->logger->write_logmessage("insert",md5($parts[1]) );	*/

			
			
			if(!empty($result)) 
				{
					$this->logger->write_logmessage("insert","###inside IF1 #####" );
					$session_data = array(
					'username' => $result->username,
					'password' => $result->password,
										  );
						
					//$this->logger->write_logmessage("insert","###after session #####" );		
					
					
					$this->session->set_userdata($session_data);
					
					
					/*$this->load->view('mobile/leavemgmt');
					$this->logger->write_logmessage("insert","###inside IF #####" );
					echo json_encode($session_data);*/
				}				
					
			else
				{
					
					$this->load->view('mobile/loginview');
					$this->logger->write_logmessage("insert","###inside ELSE #####" );
				}
			
		}
		
		public function test()
		{
			$this->load->view('mobile/leavemgmt');
		}
		
		public function logout() 
		{
		
		$sess_array = array(
		'username' => ''
		);
		
		$this->session->unset_userdata('username', $sess_array);
		
		//$data['message_display'] = 'Successfully Logout';
		//send manual value to js
		//$this->load->view('mobile/loginview.php',$session_data );
		redirect('mobile/loginview.php');
		}
	}
?>