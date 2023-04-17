<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("Model_myclass", "mmc", TRUE);
        $this->load->model('Model_table', "mt", TRUE);
    }

    public function forgotpassword()  {
        $data['title'] = "Forgot Password";
        $this->load->view('Administrator/ForgotPassword', $data);
    }
		
	public function brach_access($id) {
		$data['branch_id'] = $id;
        $this->load->view('Administrator/branch_access',$data);
    }
	public function godown_access($id) {
		$data['branch_id'] = $id;
        $this->load->view('Administrator/godown_access',$data);
    }

    function branch_access_main_admin(){
        $branch_id = $this->input->post('branch_id');

		$row = $this->db->where('brunch_id',$branch_id)->get('tbl_brunch')->row();
		$comp_logo = $this->db->where('company_BrunchId',$branch_id)->get('tbl_company')->row()->Company_Logo_org;

        $sdata['BRANCHid'] = $row->brunch_id;
		
        $sdata['userBrunch'] = $row->Brunch_sales;
        $sdata['Brunch_name'] = $row->Brunch_name;
        $sdata['Brunch_image'] = $comp_logo;
        $sdata['active_godown'] = false;
        $this->session->set_userdata($sdata);
		//echo "<pre>";print_r($sdata);exit;
        redirect('Administrator/');
       
	}
    function godown_branch_access_main_admin(){
        $branch_id = $this->input->post('branch_id');

		$row = $this->db->where('brunch_id',$branch_id)->get('tbl_brunch')->row();
		$comp_logo = $this->db->where('company_BrunchId',$branch_id)->get('tbl_company')->row()->Company_Logo_org;

        $sdata['BRANCHid'] = $row->brunch_id;
        $sdata['Brunch_name'] = $row->Brunch_name;
        $sdata['active_godown'] = true;
        $this->session->set_userdata($sdata);
        redirect('Administrator/');
       
	}

    public function logout(){
        $this->session->unset_userdata('userId');
        $this->session->unset_userdata('User_Name');
        $this->session->unset_userdata('accountType');
        //$this->session->unset_userdata('useremail');
        redirect("Login");
    }

}
