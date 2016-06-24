<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
       	$this->load->library('session');
		$this->load->model('Loginmodel');
		
	}
	function index()
	{
        if($this->session->userdata('logged_in'))
        {
            redirect('scraping','refresh');
        }
        else
        {
            $data['base_url']=$this->config->item('base_url');
            $data['page_title']='Login Kuberin';
            $this->load->view('login_view',$data);
        }

	}
    function login()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|callback_cek_database');
        if($this->form_validation->run()==FALSE)
        {
            echo json_encode(array('st'=>0,'msg'=>validation_errors()));
        }
        else
        {
            $tampung = $this->config->item('base_url');
            echo json_encode(array('st'=>1,'msg'=>$tampung.'index.php/scraping'));

        }

    }
    function cek_database($password)
    {
        $pswd = md5($password);
        $username = $this->input->post('username');
        $result = $this->Loginmodel->Login($username, $pswd);

        if($result)
        {
            foreach($result as $rows)
            {
                $user = array(
                    'id_user' 		=> $rows->id_user,
                    'nama'		=> $rows->nama,
                    'username' 	=> $rows->username,

                );

            }
            $this->session->set_userdata('logged_in',$user);
            return true;
        }
        else
        {
            $this->form_validation->set_message('cek_database', 'Invalid username or password');
            return false;
        }
    }

	function logout()
	{
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy();
        redirect('/' ,'refresh');
        exit;
	}
}