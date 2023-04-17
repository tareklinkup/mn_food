<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("model_myclass", "mmc", TRUE);
        $this->load->model('model_table', "mt", TRUE);
    }
    public function index()  {
        $data['title'] = "Login";
        $this->load->view('login/login', $data);
    }
	
    function procedure(){
        $user = $this->input->post('user_name');
		$pass = md5($this->input->post('password'));
		$query = $this->db->query("
			SELECT 
				u.User_SlNo, 
				u.User_ID, 
				u.FullName,
				u.User_Name, 
				u.userBrunch_id, 
				u.UserType, 
				u.image_name as user_image, 
				u.status AS userstatus, 
				br.brunch_id, 
				br.Brunch_name, 
				br.Brunch_sales,
				g.brunch_id as godown_id,
				g.Brunch_name as godown_name

			FROM tbl_user AS u 
			LEFT JOIN tbl_brunch AS br ON br.brunch_id = u.userBrunch_id
			left join tbl_brunch AS g ON g.brunch_id = u.godown
			where br.status = 'a' 
			and u.User_Name = ? 
			AND u.User_Password = ?", [$user, $pass]);
		$data = $query->row();

		// $godown = $this->db->where("is_godown", true)->where('status', 'a')->get("tbl_brunch")->row();
		//echo "<pre>";print_r($data); echo count($data);echo $data->userstatus;exit;
		if(isset($data)){
			
			if ($data->userstatus=='a') {
				//if ($data->UserType =='a' or $data->UserType=='m') {
					//echo "Test";exit;
				$company = $this->db->select(['Company_Logo_org', 'Currency_Name'])->get('tbl_company')->row();
					$sdata['userId'] = $data->User_SlNo;
					$sdata['BRANCHid'] = $data->godown_id == null || $data->godown_id == "" ? $data->userBrunch_id : $data->godown_id;
					// $sdata['godownId'] = $godown->brunch_id;
					// $sdata['godownName'] = $godown->Brunch_name;
					$sdata['FullName'] = $data->FullName;
					$sdata['User_Name'] = $data->User_Name;
					$sdata['user_image'] = $data->user_image;
					$sdata['accountType'] = $data->UserType;
					$sdata['userBrunch'] = $data->Brunch_sales;
					$sdata['Brunch_name'] = $data->godown_id == null || $data->godown_id == "" ? $data->Brunch_name : $data->godown_name;
					$sdata['active_godown'] = $data->godown_id == null || $data->godown_id == "" ? false : true;
					$sdata['Brunch_image'] = $company->Company_Logo_org;
					$sdata['Currency_Name'] = $company->Currency_Name;
					$this->session->set_userdata($sdata);
					redirect('Administrator/');

				//}else{
					/* $sdata['userId'] = $data->User_SlNo;
					$sdata['BRANCHid'] = $data->userBrunch_id;
					$sdata['FullName'] = $data->FullName;
					$sdata['User_Name'] = $data->User_Name;
					$sdata['accountType'] = $data->UserType;
					$sdata['userBrunch'] = $data->Brunch_sales;
					$sdata['Brunch_name'] = $data->Brunch_name;
					$this->session->set_userdata($sdata); */
					//redirect('page/');
					//redirect('Administrator/');
				//}
			}else{
				$sdata['message'] = "Sorry your are deactivated";
				$this->load->view('login/login', $sdata);
			}
		}else{
			 $sdata['message'] = "Invalid User name or Password";
             $this->load->view('login/login', $sdata);
		}
    }
    

    public function forgotpassword()  {
        $data['title'] = "Forgot Password";
        $this->load->view('ForgotPassword', $data);
    }

    public function logout(){
        $this->session->unset_userdata('userId');
        $this->session->unset_userdata('User_Name');
        $this->session->unset_userdata('accountType');
        $this->session->unset_userdata('module');
        //$this->session->unset_userdata('useremail');
        redirect("Login");
    }

}
