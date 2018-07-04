
<?php

class Leavemgmt extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('login_model','logmodel');
		  $this->load->model('common_model','commodel');
		  $this->load->model('User_model','usermodel');
        $this->load->model('SIS_model','sismodel');
        $this->load->model('dependrop_model','depmodel');
        $this->load->model('university_model','unimodel');
		  $this->load->helper('download');
        if(empty($this->session->userdata('id_user'))) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access!');
		  redirect('welcome');
        }
    }


    public function leaveapply()
    {
      $id=$this->session->userdata('id_user');

		 $this->leaveresult=$this->sismodel->get_listspfic2('leave_type_master','lt_id', 'lt_name');
       		 if(isset($_POST['leaveapply']))
             {
               $this->form_validation->set_rules('la_type','Leave Type','trim|xss_clean|required');
               $this->form_validation->set_rules('la_desc','Leave Purpose','trim|xss_clean|required');
               $this->form_validation->set_rules('applied_la_from_date','From Date','trim|xss_clean|required');
               $this->form_validation->set_rules('applied_la_to_date','To Date','trim|xss_clean|required');
             }

             if($this->form_validation->run()==TRUE)
             					{
             					// get the dept id of this user
             					$deptid=$this->commodel->get_listspfic1('Department','dept_id','dept_id')->dept_id;
             					$lat=$_POST['applied_la_to_date'];
             					$laf=$_POST['applied_la_from_date'];
             					$frmdt=new DateTime($laf);
             					$todt=new DateTime($lat);
                            $lat1=explode(" ",$lat);
             					$laf1=explode(" ",$laf);
             					if($lat==$laf)
             					{
             					$this->session->set_flashdata("err_message", "Leave From Date and To Date can not be same...");
                            redirect("leavemgmt/leaveapply");
             					}
                      if(($laf1[0]==$lat1[0])&&($laf1[1]<12)&&($lat1[1]<12))
                      					{
                      					$lday=0.5;
                      					$data = array(
                      					'la_type'=>$_POST['la_type'],
                      					'la_userid' => $this->session->userdata('id_user'),
                      					'la_deptid' => $deptid,
                      					'la_year' => date('Y'),
                      					'la_days'=> $lday,
                      					'la_desc'=>$_POST['la_desc'],
                      			      'applied_la_from_date'=>$_POST['applied_la_from_date'],
                                     'applied_la_to_date'=>$_POST['applied_la_to_date'],
                      					'granted_la_from_date'=>0,
                      					'granted_la_to_date'=>0
                                     );
                      					}
                      					elseif(($laf1[0]==$lat1[0])&&($laf1[1]>=12)&&($lat1[1]>12))
                      					{
                      					$lday=0.5;
                      					$data = array(
                      					'la_type'=>$_POST['la_type'],
                      					'la_userid' => $this->session->userdata('id_user'),
                      					'la_deptid' => $deptid,
                      					'la_year' => date('Y'),
                      					'la_days'=> $lday,
                      					'la_desc'=>$_POST['la_desc'],
                      			      'applied_la_from_date'=>$_POST['applied_la_from_date'],
                                     'applied_la_to_date'=>$_POST['applied_la_to_date'],
                      					'granted_la_from_date'=>0,
                      					'granted_la_to_date'=>0
                                     );

                      					}
                      					else
                      					{
                      					$lauserid=$this->sismodel->get_listspfic1('leave_apply','la_userid','la_id',$id)->la_userid;
                      					// get master values on the basis of leave type
                      					$msval = $this->sismodel->get_listspfic1('leave_type_master','lt_value','lt_id',$_POST['la_type'])->lt_value;
                      					// get the academic year
                      					$cyear = date('Y');
                      					//	get the sum of leave taken on the basis of year, user, leave type
                      					$whdata1 = array('la_status'=>1,'la_userid' => $lauserid,'la_type'=>$_POST['la_type'], 'la_year'=>$cyear);
                      					// $res= $this->sismodel->get_listspficemore('leave_apply','sum(la_taken) as latk',$whdata1);
                      					$res= $this->sismodel->get_listspficemore('leave_apply','sum(la_days) as ldays',$whdata1);
                      						foreach ($res as $row1)
                      			        	{
                      						//$ltval = $row1->latk;
                      						$ltval = $row1->ldays;
                      						}
                      						//	calculte the leave remaining = master value - taken value
                      						$this->lrmain = $msval - $ltval;
                      						$ldays=$frmdt->diff($todt);
                                     	$ldays=$ldays->format('%R%a days')+1;

                      						if($ldays<=($this->lrmain))
                      						{
                      						$data = array(
                      						'la_type'=>$_POST['la_type'],
                      						'la_userid' => $this->session->userdata('id_user'),
                      						'la_deptid' => $deptid,
                      						'la_year' => date('Y'),
                      						'la_days'=> $ldays,
                      						'la_desc'=>$_POST['la_desc'],
                      			   	   'applied_la_from_date'=>$_POST['applied_la_from_date'],
                                  	   'applied_la_to_date'=>$_POST['applied_la_to_date'],
                      						'granted_la_from_date'=>0,
                      						'granted_la_to_date'=>0
                                   		 );

                      						 }
                      						 else
                      						 {
                      		 				 $this->session->set_flashdata("err_message", "Leave can not be applied because " .$msval. " leave count is available only ...");
                               	       redirect("leavemgmt/leaveapply");
                      					 	 }
                      					 }

                      					 $leaveapply=$this->sismodel->insertrec('leave_apply', $data);
                      					 if(!$leaveapply)
                      					 {
                                        $this->logger->write_logmessage("insert"," Error in Applying Leave", "Error in Applying Leave " );
                                        $this->logger->write_dblogmessage("insert","Error in Applying Leave", " Error in Applying Leave " );
                                        $this->session->set_flashdata('err_message','Error in adding From Date ' . $_POST['lt_from_date'] , 'error');
                                        redirect('leavemgmt/leaveapply');
                                      }
                      					 elseif($lday==0.5)
                      					 {
                      					  $this->logger->write_logmessage("insert"," Half Day Leave applied successfully ", " Leave applied successfully..."  );
                                    	  $this->logger->write_dblogmessage("insert"," Half Day Leave applied successfully ", "Leave applied successfully..." );
                                    	  $this->session->set_flashdata("success", "Half Day Leave applied successfully... ");
                                    	  redirect("leavemgmt/leavestatus");
                      					 }
                      					 else
                      					 {
                      					  $this->logger->write_logmessage("insert"," Leave applied successfully ", " Leave applied successfully..."  );
                                    	  $this->logger->write_dblogmessage("insert"," Leave applied successfully ", "Leave applied successfully..." );
                                    	  $this->session->set_flashdata("success", "Leave applied successfully... ");
                                    	  redirect("leavemgmt/leavestatus");
                      					 }
                      					 }
                      	$this->load->view('leavemgmt/leavemgmt(1)');
                         return;
                      }






    }
