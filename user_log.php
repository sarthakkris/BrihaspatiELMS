<?php

//session_start(); 

Class User_Log extends CI_Controller {

public function __construct() {
parent::__construct();

//loading needed libraries
$this->load->helper('form','url');


$this->load->library('form_validation');


$this->load->library('session');


$this->load->model('login_model');
}

//if user logged in,load session tp the leavemgmt.php
public function index(){
if(isset($this->session->userdata['logged_in']))
{
$this->load->view('mobile/leavemgmt');
}
else//otherwise go to login page
 {
$this->load->view('mobile/loginview');
}

}


public function user_login_process() {
//explode and use the parts  array
$combid=$this->input->post('credentials');
$parts=explode(",",$combid);
print_r($parts[0]);die;
//$this->form_validation->set_rules('username',$parts[0],'trim|required|xss_clean');
//$this->form_validation->set_rules('password',$parts[1],'trim|required|xss_clean');

if ($this->form_validation->run() == FALSE) 
{
$this->load->view('mobile/login_view');
}
 else {
$data = array(
'username' => $parts[0],
'password' => $parts[1]
);
$result = $this->login_model->validate_user($data);
if ($result == TRUE) {

$username = $this->input->post('username');


//$result = $this->edrpuser->read_user_information($username);



if ($result != false) {
$session_data = array(
'username' => $result[0]->user_name,
'email' => $result[0]->user_email,
);

$this->session->set_userdata('logged_in', $session_data);
$this->load->view('mobile/leavemgmt');
}
} else {
//$data = array(
//'error_message' => 'Invalid Username or Password'
//);


//send manual value to js

$this->load->view('mobile/loginview');
}
}
echo json_encode($session_data);
}


public function logout() {


$sess_array = array(
'username' => ''
);
$this->session->unset_userdata('logged_in', $sess_array);
//$data['message_display'] = 'Successfully Logout';


//send manual value to js
$this->load->view('mobile/loginview.php', $data);
}

}

?>
