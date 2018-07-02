<?php
session_start(); 
Class user_log extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->helper('form','url');
$this->load->library('form_validation');
$this->load->library('session');
$this->load->model('login_model');
}
public function index() {
$this->load->view('mobile/loginview.php');
}
public function user_login_process() {
	
	$combid = $this->input->post('credentials');
	$parts = explode('&&' , $combid,1);
	
$this->form_validation->set_rules('username', 'parts[0]', 'trim|required|xss_clean');
$this->form_validation->set_rules('password', 'parts[1]', 'trim|required|xss_clean');
if ($this->form_validation->run() == FALSE) {
if(isset($this->session->userdata['logged_in'])){
$this->load->view('mobile/leavemgmt.php');
}else{
$this->load->view('mobile/loginview');
}
} else {
$data = array(
'username' => $this->input->post('username'),
'password' => $this->input->post('password')
);
$result = $this->login_database->login($data);
if ($result == TRUE) {
$username = $this->input->post('username');
$result = $this->login_database->read_user_information($username);
if ($result != false) {
$session_data = array(
'username' => $result[0]->user_name,
'email' => $result[0]->user_email,
);
$this->session->set_userdata('logged_in', $session_data);
$this->load->view('mobile/leavemgmt.php');
}
} 
);
$this->load->view('mobile/loginview', $data);
}
}

public function logout() {
$sess_array = array(
'username' => ''
);
$this->session->unset_userdata('logged_in', $sess_array);

$this->load->view('mobile/loginview', $data);
}
}
?>
